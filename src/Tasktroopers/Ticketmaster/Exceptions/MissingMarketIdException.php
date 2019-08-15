<?php
namespace Tasktroopers\Ticketmaster\Exceptions;

/**
 * Used when provided market id is unknown
 */
class MissingMarketIdException extends \RuntimeException
{
    /**
     * Provides hard coded error message with the unknown market id
     *
     * @param int $marketId
     * @param \Exception $previous
     */
    public function __construct(int $marketId, \Exception $previous = null)
    {
        parent::__construct(
            'Provided market ID (' . (string)$marketId . ') unknown.',
            0,
            $previous
        );
    } 
}