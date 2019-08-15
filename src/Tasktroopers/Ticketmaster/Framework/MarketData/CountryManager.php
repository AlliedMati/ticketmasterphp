<?php
namespace Tasktroopers\Ticketmaster\Framework\MarketData;

use Tasktroopers\Ticketmaster\Framework\MarketData\Country;

/**
 * Singleton class that manages the list of country records
 */
class CountryManager
{
    /**
     * Holds list of country records
     *
     * @var array
     */
    private $countryRecords;

    /**
     * Gets list of country records
     *
     * @return array
     */
    public function getCountryRecords(): array
    {
        return $this->countryRecords;
    }

    /**
     * Add record to list of country records
     *
     * @param Tasktroopers\Ticketmaster\Framework\MarketData\Country $value
     * @return void
     */
    public function addCountryRecord(Country $value): void
    {
        $this->countryRecords[] = $value;
    }

    /**
     * Gets a single country record based on the provided country code
     *
     * @param string $code
     * @return Tasktroopers\Ticketmaster\Framework\MarketData\Country
     */
    public function getCountryRecordFromCode(string $code): Country
    {
        // attempt to find country record by provided country code
        foreach($this->getCountryRecords() as $countryRecord) {
            if ($countryRecord->getCode() == $code) {
                return $countryRecord;
            }
        }

        // if we are here, it means the country record wasn't found
        // so throw exception that a fitting country code wasn't found
        throw new MissingCountryCodeException($code);
    }

    /**
     * Holds the only allowed instance of this class
     *
     * @var Tasktroopers\Ticketmaster\Framework\MarketData\CountryManager
     */
    private static $instance;

    /**
     * Gets the only allowed instance of this class
     *
     * @return Tasktroopers\Ticketmaster\Framework\MarketData\CountryManager
     */
    public static function getInstance(): CountryManager
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Load json file with list of country records 
     * and convert to PHP array
     */
    private function __construct()
    {
        $this->countryRecords = [];

        // read the json file that lists all known country records
        // and convert to PHP array
        $countryRecord = json_decode(
            file_get_contents($_ENV['COUNTRIES_FILE']),
            true
        );

        // add all country records to array converted to country records
        foreach ($countryRecords as $countryRecord) {
            $this->addException(new Country($countryRecord));
        }
    }

    /**
     * Magic method __clone is empty to prevent duplication
     *
     * @return void
     */
    private function __clone() { }
}