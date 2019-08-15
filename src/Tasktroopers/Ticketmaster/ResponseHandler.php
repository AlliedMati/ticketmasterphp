<?php
namespace Tasktroopers\Ticketmaster;

use Tasktroopers\Ticketmaster\TicketmasterExceptionHandler;

/**
 * Handles a response returned by the api and breaks it apart
 * in an easy to understand way
 */
class ResponseHandler
{
    /**
     * Holds a response body decoded into a string array
     *
     * @var string
     */
    private $body;

    /**
     * Gets a response body
     *
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * Sets a response body and converts json to a php string array
     *
     * @param string $value json input data
     * @return void
     */
    public function setBody(string $value): void
    {
        if ($value != '') {
            $this->body = json_decode($value, true);
        } else {
            $this->body = [];
        }
    }

    /**
     * Holds a http status code
     *
     * @var int
     */
    private $statusCode;

    /**
     * Gets a http status code
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Sets a http status code
     *
     * @param int $value
     * @return void
     */
    public function setStatusCode(int $value): void
    {
        $this->statusCode = $value;
    }

    /**
     * Holds the rate limit returned by the api connected to the provided api key
     *
     * @var int
     */
    private $rateLimit;

    /**
     * Gets the rate limit
     *
     * @return int
     */
    public function getRateLimit(): int
    {
        return $this->rateLimit;
    }

    /**
     * Sets the rate limit
     *
     * @param int $value
     * @return void
     */
    public function setRateLimit(int $value): void
    {
        $this->rateLimit = $value;
    }

    /**
     * Holds the available rate limit returned by the api connected to the provided api key
     * The available rate limit shows how many request are left over a 24hr period
     *
     * @var string
     */
    private $rateLimitAvailable;

    /**
     * Gets the available rate limit
     *
     * @return int
     */
    public function getRateLimitAvailable(): int
    {
        return $this->rateLimitAvailable;
    }

    /**
     * Sets the available rate limit
     *
     * @param int $value
     * @return void
     */
    public function setRateLimitAvailable(int $value): void
    {
        $this->rateLimitAvailable = $value;
    }

    /**
     * Holds the rate limit reset timestamp
     * This time stamp describes when the rate limit will be reset to its default value (getRateLimit())
     *
     * @var \DateTime
     */
    private $rateLimitReset;

    /**
     * Gets the rate limit reset datetime
     *
     * @return \DateTime
     */
    public function getRateLimitReset(): \DateTime
    {
        return $this->rateLimitReset;
    }

    /**
     * Sets the rate limit reset datetime
     *
     * @param integer $value a unix timestamp
     * @return void
     */
    public function setRateLimitReset(int $value): void
    {
        // convert unix timestamp to a DateTime object
        $this->rateLimitReset = new \DateTime('@' . $value);
    }

    /**
     * Holds wether the api key is valid or not
     *
     * @var bool
     */
    private $isValidApiKey;

    /**
     * Gets wether the api key is valid or not
     *
     * @return bool
     */
    public function getIsValidApiKey(): bool
    {
        return $this->isValidApiKey;
    }

    /**
     * Sets wether the api key is valid or not
     *
     * @param bool $value
     * @return void
     */
    public function setIsValidApiKey(bool $value): void
    {
        $this->isValidApiKey = $value;
    }

    /**
     * Holds wether the api uri is valid or not
     *
     * @var bool
     */
    private $isValidApiUri;

    /**
     * Gets wether the api uri is valid or not
     *
     * @return bool
     */
    public function getIsValidApiUri(): bool
    {
        return $this->isValidApiUri;
    }

    /**
     * Sets wether the api uri is valid or not
     *
     * @param bool $value
     * @return void
     */
    public function setIsValidApiUri(bool $value): void
    {
        $this->isValidApiUri = $value;
    }

    /**
     * Breaks apart a given GuzzleHttp response into an easy to understand format
     * directed at the Ticketmaster api
     *
     * @param GuzzleHttp\Psr7\Response $response
     */
    public function __construct(\GuzzleHttp\Psr7\Response $response)
    {
        // first save the http status code and response body
        $this->setStatusCode($response->getStatusCode());
        $this->setBody($response->getBody());

        // update basic information about correctness of uri and api
        // when http status is 200/OK
        if ($this->isOk()) {
            $this->setIsValidApiKey(true);
            $this->setIsValidApiUri(true);
        }

        // check if fault is available and throw exception if found
        try {
            $eh = TicketmasterExceptionHandler::getInstance();
        
            if ($eh->hasExceptionInResponseBody($this->getBody())) {
                $e = $eh->getExceptionFromResponseBody($this->getBody());
                $e->throw();
            }
        } catch (MissingApiKeyException $e) {
            $this->setIsValidApiKey(false);
            $this->setIsValidApiUri(false);
        } catch (InvalidApiKeyException $e) {
            $this->setIsValidApiKey(false);
            $this->setIsValidApiUri(true);
        } catch (MissingTicketmasterException $e) {
            // TODO: handle this
        } catch (Exception $e) {
            // TODO: handle this
        }

        // handle rate limit info from headers
        $this->setRateLimitInfo($response);
    }

    /**
     * Check if rate limit headers are available and set their value if so
     *
     * @param GuzzleHttp\Psr7\Response $response
     * @return void
     */
    public function setRateLimitInfo(\GuzzleHttp\Psr7\Response $response): void
    {
        // the overal 24hr rate limit
        if ($response->hasHeader('Rate-Limit')) {
            $this->setRateLimit((int)$response->getHeader('Rate-Limit')[0]);
        }

        // how many request can still be made
        if ($response->hasHeader('Rate-Limit-Available')) {
            $this->setRateLimitAvailable((int)$response->getHeader('Rate-Limit-Available')[0]);
        }

        // when the rate limit will be reset to the overal 24hr rate limit (unix time of reset time)
        if ($response->hasHeader('Rate-Limit-Reset')) {
            // cut off last 3 numbers
            $rateLimitReset = substr($response->getHeader('Rate-Limit-Reset')[0], 0, -3);

            // cast to int and save
            $this->setRateLimitReset((int)$rateLimitReset);
        }
    }

    /**
     * Quick check if response was http status OK
     *
     * @return bool
     */
    public function isOk(): bool
    {
        return $this->getStatusCode() == 200;
    }

    /**
     * Quick check if response was http status unauthorized
     *
     * @return bool
     */
    public function isUnauthorized(): bool
    {
        return $this->getStatusCode() == 401;
    }

    /**
     * Quick check if response was http status resource not found
     *
     * @return bool
     */
    public function isResourceNotFound(): bool
    {
        return $this->getStatusCode() == 404;
    }

    /**
     * Quick check if response was http status invalid request method
     *
     * @return bool
     */
    public function isInvalidRequestMethod(): bool
    {
        return $this->getStatusCode() == 405;
    }
}