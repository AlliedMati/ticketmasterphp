<?php
namespace Tasktroopers\Ticketmaster;

use Tasktroopers\Ticketmaster\{
    RequestHandler,
    ResponseHandler
};

use Tasktroopers\Tickermaster\Exceptions\{
    InvalidApiKeyException,
    MissingApiKeyException,
    ConnectionException
};

/**
 * Starting point of the Ticketmaster api SDK
 */
class Client
{
    /**
     * Holds a valid api key
     *
     * @var string
     */
    private $apiKey;

    /**
     * Returns the api key
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Sets api key
     *
     * @param string $value
     * @return void
     */
    public function setApiKey(string $value)
    {
        $this->apiKey = $value;
    }

    /**
     * Holds the api root uri
     *
     * @var string
     */
    private $apiRoot;

    /**
     * Gets the api root uri
     *
     * @return string
     */
    public function getApiRoot(): string
    {
        return $this->apiRoot;
    }

    /**
     * Sets the api root uri
     *
     * @param string $value
     * @return void
     */
    public function setApiRoot(string $value)
    {
        $this->apiRoot = $value;
    }

    /**
     * Holds the api key suffix to the uri (e.g. ?apikey=%s)
     *
     * @var string
     */
    private $apiRootSuffix;

    /**
     * Gets the api key suffix to the uri
     *
     * @return string
     */
    public function getApiRootSuffix(): string
    {
        return $this->apiRootSuffix;
    }

    /**
     * Sets the api key suffix to the uri
     *
     * @param string $value
     * @return void
     */
    public function setApiRootSuffix(string $value)
    {
        $this->apiRootSuffix = $value;
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
    public function setRateLimit(int $value)
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
    public function setRateLimitAvailable(int $value)
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
     * @param DateTime $value
     * @return void
     */
    public function setRateLimitReset(\DateTime $value)
    {
        $this->rateLimitReset = $value;
    }

    /**
     * Initializes a client object
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        // load values from .env file
        $dotenv = \Dotenv\Dotenv::create(dirname(__FILE__) . '/' . '../../Config/');
        $dotenv->load();

        // prepare the uri basics
        $this->setApiKey($apiKey);
        $this->setApiRoot($_ENV['API_ROOT']);
        $this->setApiRootSuffix($_ENV['API_KEY_SUFFIX']);
    }

    /**
     * Builds a valid uri based on api root, resource, api key suffix
     * and the api key itself
     *
     * @param string $resource
     * @return string
     */
    public function getUri(string $resource): string
    {
        // build a url from base api url, the resource that's being called,
        // the api suffix that's required and a valid api key
        return $this->getApiRoot() . $resource . sprintf($this->getApiRootSuffix(), $this->getApiKey());
    }

    /**
     * Sends a get request to the request handler
     *
     * @param string $resource
     * @return Tasktroopers\Ticketmaster\ResponseHandler
     */
    public function get(string $resource): ResponseHandler
    {
        $request = new RequestHandler($this);
        return $request->get($resource);
    }

    /**
     * Sends a post request to the request handler
     *
     * @param string $resource
     * @return Tasktroopers\Ticketmaster\ResponseHandler
     */
    public function post(string $resource): ResponseHandler
    {
        $request = new RequestHandler($this);
        return $request->post($resource);
    }
}