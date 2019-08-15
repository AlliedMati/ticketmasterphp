<?php
namespace Tasktroopers\Ticketmaster\Framework\Marketdata;

/**
 * Represents a market entitiy from markets.json
 * Markets can be used to filter events by larger
 * regional demographic groupings. Each market is
 * typically comprised of several DMAs.
 */
class Market
{
    /**
     * Holds the market id
     *
     * @var int
     */
    private $id;

    /**
     * Gets the market id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets the market id
     *
     * @param integer $value
     * @return void
     */
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    /**
     * Holds the market name
     *
     * @var string
     */
    private $market;

    /**
     * Gets the market name
     *
     * @return string
     */
    public function getMarket(): string
    {
        return $this->market;
    }

    /**
     * Sets the market name
     *
     * @param string $value
     * @return void
     */
    public function setMarket(string $value): void
    {
        $this->market = $value;
    }

    /**
     * Holds the market region
     *
     * @var string
     */
    private $region;

    /**
     * Gets the market region
     *
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * Sets the market region
     *
     * @param string $value
     * @return void
     */
    public function setRegion(string $value): void
    {
        $this->region = $value;
    }

    /**
     * Prepare a market object from a php array record
     *
     * @param array $record
     */
    public function __construct(array $record)
    {
        $this->setId((int)$record['id']);
        $this->setMarket($record['market']);
        $this->setRegion($record['region']);
    }
}