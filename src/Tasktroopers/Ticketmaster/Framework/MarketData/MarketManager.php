<?php
namespace Tasktroopers\Ticketmaster\Framework\MarketData;

use Tasktroopers\Ticketmaster\Framework\MarketData\Market;

/**
 * Singleton class that manages the list of market records
 */
class MarketManager
{
    /**
     * Holds list of market records
     *
     * @var array
     */
    private $marketRecords;

    /**
     * Gets list of market records
     *
     * @return array
     */
    public function getMarketRecords(): array
    {
        return $this->marketRecords;
    }

    /**
     * Add record to list of markets records
     *
     * @param Tasktroopers\Ticketmaster\Framework\MarketData\Market $value
     * @return void
     */
    public function addMarketRecord(Market $value): void
    {
        $this->marketRecords[] = $value;
    }

    /**
     * Gets a single maret record based on the provided market id
     *
     * @param int $id
     * @return Tasktroopers\Ticketmaster\Framework\MarketData\Market
     */
    public function getMarketRecordFromId(int $id): Market
    {
        // attempt to find market record by provided market id
        foreach($this->getMarketRecords() as $marketRecord) {
            if ($marketRecord->getId() == $id) {
                return $marketRecord;
            }
        }

        // if we are here, it means the market record wasn't found
        // so throw exception that a fitting market id wasn't found
        throw new MissingMarketIdException($id);
    }

    /**
     * Holds the only allowed instance of this class
     *
     * @var Tasktroopers\Ticketmaster\Framework\MarketData\MarketManager
     */
    private static $instance;

    /**
     * Gets the only allowed instance of this class
     *
     * @return Tasktroopers\Ticketmaster\Framework\MarketData\MarketManager
     */
    public static function getInstance(): MarketManager
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Load json file with list of dma records 
     * and convert to PHP array
     */
    private function __construct()
    {
        $this->marketRecords = [];

        // read the json file that lists all known market records
        // and convert to PHP array
        $marketRecords = json_decode(
            file_get_contents($_ENV['MARKETS_FILE']),
            true
        );

        // add all market records to array converted to market records
        foreach ($marketRecords as $marketRecord) {
            $this->addException(new Market($marketRecord));
        }
    }

    /**
     * Magic method __clone is empty to prevent duplication
     *
     * @return void
     */
    private function __clone() { }
}