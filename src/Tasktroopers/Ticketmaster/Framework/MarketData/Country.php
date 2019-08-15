<?php
namespace Tasktroopers\Ticketmaster\Framework\Marketdata;

/**
 * Represents a country code from countries.json
 * ISO Alpha-2 Code country values
 */
class Country
{
    /**
     * Holds the country code
     *
     * @var string
     */
    private $code;

    /**
     * Gets the country code
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Sets the country code
     *
     * @param string $value
     * @return void
     */
    public function setCode(string $value): void
    {
        $this->id = $value;
    }

    /**
     * Holds the country name
     *
     * @var string
     */
    private $name;

    /**
     * Gets the country name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the country name
     *
     * @param string $value
     * @return void
     */
    public function setName(string $value): void
    {
        $this->name = $value;
    }

    /**
     * Prepare a country object from a php array record
     *
     * @param array $record
     */
    public function __construct(array $record)
    {
        $this->setCode($record['code']);
        $this->setName($record['name']);
    }
}