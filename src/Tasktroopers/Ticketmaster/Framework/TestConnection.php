<?php
namespace Tasktroopers\Ticketmaster\Framework;

use Tasktroopers\Ticketmaster\{
    Client,
    ResponseHandler
};

/**
 * Used to test connectivity and API key validity
 */
class TestConnection
{
    /**
     * Holds a reference to the Client object
     *
     * @var Tasktroopers\Ticketmaster\Client
     */
    private $client;

    /**
     * Gets Client
     *
     * @return Tasktroopers\Ticketmaster\Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Sets Client
     *
     * @param Tasktroopers\Ticketmaster\Client $value
     * @return void
     */
    public function setClient(Client $value)
    {
        $this->client = $value;
    }

    /**
     * Holds a reference to the last received response 
     *
     * @var Tasktroopers\Ticketmaster\ResponseHolder
     */
    private $response;

    /**
     * Gets the last received response
     *
     * @return Tasktroopers\Ticketmaster\ResponseHandler
     */
    public function getResponse(): ResponseHandler
    {
        return $this->response;
    }

    /**
     * Sets the last received response
     *
     * @param Tasktroopers\Ticketmaster\ResponseHandler $value
     * @return void
     */
    public function setResponse(ResponseHandler $value)
    {
        $this->response = $value;
    }

    /**
     * Saves reference to the client
     *
     * @param Tasktroopers\Ticketmaster\Client $client
     */
    public function __construct(Client $client)
    {
        $this->setClient($client);
    }

    /**
     * Tests a get request
     *
     * @return bool
     */
    public function testGet(): bool
    {
        $this->setResponse($this->getClient()->get(''));

        return $this->getResponse()->isOk();
    }

    /**
     * Tests a post request
     *
     * @return bool
     */
    public function testPost(): bool
    {
        $this->setResponse($this->getClient()->post(''));

        return $this->getResponse()->isOk();
    }
}