<?php
namespace Tasktroopers\Ticketmaster\Exceptions;

/**
 * Used when provided fault code is unknown
 */
class MissingTicketmasterException extends \RuntimeException
{
    /**
     * Provides hard coded error message with the unknown fault code
     *
     * @param string $faultCode
     * @param \Exception $previous
     */
    public function __construct(string $faultCode, \Exception $previous = null)
    {
        parent::__construct(
            'Unknown error. Ticketmaster API fault code (' . $faultCode . ') unknown.',
            0,
            $previous
        );
    } 
}