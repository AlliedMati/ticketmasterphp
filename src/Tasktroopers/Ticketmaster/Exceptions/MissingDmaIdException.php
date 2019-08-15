<?php
namespace Tasktroopers\Ticketmaster\Exceptions;

/**
 * Used when provided dma id is unknown
 */
class MissingDmaIdException extends \RuntimeException
{
    /**
     * Provides hard coded error message with the unknown dma id
     *
     * @param string $dmaId
     * @param \Exception $previous
     */
    public function __construct(int $dmaId, \Exception $previous = null)
    {
        parent::__construct(
            'Provided market ID (' . (string)$dmaId . ') unknown.',
            0,
            $previous
        );
    } 
}