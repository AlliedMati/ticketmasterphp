<?php
namespace Tasktroopers\Ticketmaster\Framework\Marketdata;

/**
 * Represents a dma entitiy from dma.json
 * Designated Market Area (DMA) can be used to segment
 * and target events to a specific audience. Each DMA
 * groups several zipcodes into a specific market segmentation
 * based on population demographics.
 */
class Dma
{
    /**
     * Holds the dma id
     *
     * @var int
     */
    private $id;

    /**
     * Gets the dma id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets the dma id
     *
     * @param integer $value
     * @return void
     */
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    /**
     * Holds the dma name
     *
     * @var string
     */
    private $name;

    /**
     * Gets the dma name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the dma name
     *
     * @param string $value
     * @return void
     */
    public function setName(string $value): void
    {
        $this->name = $value;
    }

    /**
     * Prepare a dma object from a php array record
     *
     * @param array $record
     */
    public function __construct(array $record)
    {
        $this->setId((int)$record['id']);
        $this->setName($record['name']);
    }
}