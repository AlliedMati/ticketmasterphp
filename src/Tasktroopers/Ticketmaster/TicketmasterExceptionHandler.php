<?php
namespace Tasktroopers\Ticketmaster;

use Tasktroopers\Ticketmaster\TicketmasterException;

/**
 * Singleton class to avoid reading json file over and over
 */
class TicketmasterExceptionHandler
{
    /**
     * Holds list of Ticketmaster specific exceptions
     *
     * @var array
     */
    private $exceptions;

    /**
     * Gets list of Ticketmaster specific exceptions
     *
     * @return array
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }

    /**
     * Add exception to list of Ticketmaster specific exceptions
     *
     * @param Tasktroopers\Ticketmaster\TicketmasterException $value array of strings
     * @return void
     */
    public function addException(TicketmasterException $value): void
    {
        $this->exceptions[] = $value;
    }

    /**
     * Gets a single exception based on the provided ticket master returned fault code
     *
     * @param string $faultCode
     * @return Tasktroopers\Ticketmaster\TicketmasterException
     */
    public function getExceptionFromFaultCode(string $faultCode): TicketmasterException
    {
        // attempt to find exception by provided fault code
        foreach($this->getExceptions() as $exception) {
            if ($exception->getFaultCode() == $faultCode) {
                return $exception;
            }
        }

        // if we are here, it means the exception wasn't found
        // so throw exception that a fitting Ticketmaster exception wasn't found
        throw new MissingTicketMasterException($faultCode);
    }

    /**
     * Looks for the matching exception from the given response body
     *
     * @param array $responseBody
     * @return Tasktroopers\Ticketmaster\TicketMasterException or null if none found in response body
     */
    public function getExceptionFromResponseBody(array $responseBody): TicketMasterException
    {
        if ($this->hasExceptionInResponseBody($responseBody)) {
            return $this->getExceptionFromFaultCode(
                $responseBody['fault']['detail']['errorcode']
            );
        } else {
            return null;
        }
    }

    /**
     * Returns true if a fault code has been found in the response body
     *
     * @param array $responseBody
     * @return bool
     */
    public function hasExceptionInResponseBody(array $responseBody): bool
    {
        return isset($responseBody['fault']['detail']['errorcode']);
    }

    /**
     * Holds the only allowed instance of this class
     *
     * @var Tasktroopers\Ticketmaster\TicketmasterExceptionHandler
     */
    private static $instance;

    /**
     * Gets a the only allowed instance of this class
     *
     * @return Tasktroopers\Ticketmaster\TicketmasterExceptionHandler
     */
    public static function getInstance(): TicketmasterExceptionHandler
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Load json file with list of Ticketmaster specific exceptions 
     * and convert to PHP array
     */
    private function __construct()
    {
        $this->exceptions = [];

        // read the json file that lists all known Ticketmaster exceptions
        // and convert to PHP array
        $exceptions = json_decode(
            file_get_contents($_ENV['TICKETMASTER_EXCEPTIONS_FILE']),
            true
        );

        // add all exceptions to array converted to TicketmasterException type
        foreach ($exceptions as $exception) {
            $this->addException(new TicketmasterException($exception));
        }
    }

    /**
     * Magic method __clone is empty to prevent duplication
     *
     * @return void
     */
    private function __clone() { }
}