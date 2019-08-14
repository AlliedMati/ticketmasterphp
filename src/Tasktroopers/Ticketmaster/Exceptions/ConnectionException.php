<?php
namespace Tasktroopers\Ticketmaster\Exceptions;

/**
 * Used when connection could not be made with the api
 */
class ConnectionException extends \RuntimeException
{
    /**
     * Provide hard coded error message
     *
     * @param \Exception $previous
     */
    public function __construct(\Exception $previous = null)
    {
        parent::__construct(
            'Ticketmaster API not available. Connection could not be made.',
            0,
            $previous
        );
    }
}