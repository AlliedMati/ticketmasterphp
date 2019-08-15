<?php
namespace Tasktroopers\Ticketmaster\Framework\MarketData;

use Tasktroopers\Ticketmaster\Framework\MarketData\Dma;

/**
 * Singleton class that manages the list of dma records
 */
class DmaManager
{
    /**
     * Holds list of dma records
     *
     * @var array
     */
    private $dmaRecords;

    /**
     * Gets list of dma records
     *
     * @return array
     */
    public function getDmaRecords(): array
    {
        return $this->dmaRecords;
    }

    /**
     * Add record to list of dma records
     *
     * @param Tasktroopers\Ticketmaster\Framework\MarketData\Dma $value
     * @return void
     */
    public function addDmaRecord(Dma $value): void
    {
        $this->getDmaRecords[] = $value;
    }

    /**
     * Gets a single dma record based on the provided dma id
     *
     * @param int $id
     * @return Tasktroopers\Ticketmaster\Framework\MarketData\Dma
     */
    public function getDmaRecordFromId(int $id): Dma
    {
        // attempt to find dma record by provided dma id
        foreach($this->getDmaRecords() as $dmaRecord) {
            if ($dmaRecord->getId() == $id) {
                return $dmaRecord;
            }
        }

        // if we are here, it means the dma record wasn't found
        // so throw exception that a fitting dma id wasn't found
        throw new MissingDmaIdException($id);
    }

    /**
     * Holds the only allowed instance of this class
     *
     * @var Tasktroopers\Ticketmaster\Framework\MarketData\DmaManager
     */
    private static $instance;

    /**
     * Gets a the only allowed instance of this class
     *
     * @return Tasktroopers\Ticketmaster\Framework\MarketData\DmaManager
     */
    public static function getInstance(): DmaManager
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
        $this->dmaRecords = [];

        // read the json file that lists all known dma records
        // and convert to PHP array
        $dmaRecords = json_decode(
            file_get_contents($_ENV['DMA_FILE']),
            true
        );

        // add all dma records to array converted to dma records
        foreach ($dmaRecords as $dmaRecord) {
            $this->addException(new Dma($dmaRecord));
        }
    }

    /**
     * Magic method __clone is empty to prevent duplication
     *
     * @return void
     */
    private function __clone() { }
}