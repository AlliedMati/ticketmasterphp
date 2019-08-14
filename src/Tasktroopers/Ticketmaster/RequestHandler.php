<?php
namespace Tasktroopers\Ticketmaster;

use Tasktroopers\Ticketmaster\Exceptions\ConnectionException;
use Tasktroopers\Ticketmaster\{
    Client,
    ResponseHandler
};

/**
 * Handles a http request
 */
class RequestHandler
{
    /**
     * Holds a reference to a client
     *
     * @var Tasktroopers\Ticketmaster\Client
     */
    private $client;

    /**
     * Gets the set client
     *
     * @return Tasktroopers\Ticketmaster\Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Sets a reference to a client
     *
     * @param Tasktroopers\Ticketmaster\Client $value
     * @return void
     */
    public function setClient(Client $value)
    {
        $this->client = $value;
    }

    /**
     * Prepares with the provided Ticketmaster Client
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Sends a http get request
     *
     * @param string $resource
     * @return void
     */
    public function get(string $resource): ResponseHandler
    {
        return $this->Request('GET', $resource);
    }

    /**
     * Sends a http post request
     *
     * @param string $resource
     * @return void
     */
    public function post(string $resource): ResponseHandler
    {
        return $this->Request('POST', $resource);
    }

    /**
     * Sends a http request
     *
     * @param string $requestMethod
     * @param string $resource
     * @return Tasktroopers\Ticketmaster\ResponseHandler
     */
    public function request(string $requestMethod, string $resource): ResponseHandler
    {
        try {
            $guzzle = new \GuzzleHttp\Client();

            // pass a request and immediately convert its response to a ResponseHandler object
            $response = new ResponseHandler(
                $guzzle->request(
                    $requestMethod,
                    $this->client->getUri($resource)
                )
            );

            // transfer up to date rate limit information also to the client
            $this->updateRateLimit($response);

            // return the response to the caller
            return $response;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // couldn't connect
            throw new ConnectionException($e);
        }
    }

    /**
     * Updates rate limit information on client level
     *
     * @return void
     */
    private function updateRateLimit($response)
    {
        $client = $this->getClient();

        $client->setRateLimit($response->getRateLimit());
        $client->setRateLimitAvailable($response->getRateLimitAvailable());
        $client->setRateLimitReset($response->getRateLimitReset());
    }
}