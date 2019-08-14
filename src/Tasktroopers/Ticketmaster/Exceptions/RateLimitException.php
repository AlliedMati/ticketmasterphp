<?php
namespace Tasktroopers\Ticketmaster\Exceptions;

/**
 * Used when rate limit of requests per 24hr (typically max 5000) has been reached
 */
class RateLimitException extends \RuntimeException
{
    /**
     * Provide hard coded error message
     *
     * @param \Exception $previous
     */
    public function __construct(\Exception $previous = null)
    {
        parent::__construct(
            'Rate limit quota violation. Quota limit exceeded.',
            0,
            $previous
        );
    } 
}