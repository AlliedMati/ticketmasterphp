<?php
namespace Tasktroopers\Ticketmaster\Exceptions;

/**
 * Used when provided country code is unknown
 */
class MissingCountryCodeException extends \RuntimeException
{
    /**
     * Provides hard coded error message with the unknown country code
     *
     * @param string $countryCode
     * @param \Exception $previous
     */
    public function __construct(string $countryCode, \Exception $previous = null)
    {
        parent::__construct(
            'Provided country code (' . $countryCode . ') unknown.',
            0,
            $previous
        );
    } 
}