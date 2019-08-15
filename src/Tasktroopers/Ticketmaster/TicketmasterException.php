<?php
namespace Tasktroopers\Ticketmaster;

/**
 * Stores a single Tiketmaster specific exception
 * Converts from string array
 */
class TicketmasterException
{
    /**
     * Holds the Ticketmaster fault code
     *
     * @var string
     */
    private $faultCode;

    /**
     * Gets the Ticketmaster fault code
     *
     * @return string
     */
    public function getFaultCode(): string
    {
        return $faultCode;
    }

    /**
     * Sets the Ticketmaster fault code
     *
     * @param string $value
     * @return void
     */
    public function setFaultCode(string $value): void
    {
        $this->faultCode = $value;
    }

    /**
     * Holds the configured exception message
     *
     * @var string
     */
    private $message;

    /**
     * Gets the configured exception message
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Sets the configured exception message
     *
     * @param string $value
     * @return void
     */
    public function setMessage(string $value): void
    {
        $this->message = $value;
    }

    /**
     * Holds the compatible exception class name
     *
     * @var string
     */
    private $exceptionClass;

    /**
     * Gets the compatible exception class name
     *
     * @return string
     */
    public function getExceptionClass(): string
    {
        return $this->exceptionClass;
    }

    /**
     * Sets the compatible exception class name
     *
     * @param string $value
     * @return void
     */
    public function setExceptionClass(string $value): void
    {
        $this->exceptionClass = $value;
    }

    /**
     * Converts input array to this class' type
     *
     * @param array $input
     */
    public function __construct(array $input)
    {
        $this->setFaultCode($input['faultCode']);
        $this->setMessage($input['message']);
        $this->setExceptionClass($input['exception']);
    }

    /**
     * Throw an exception crafted from the given data
     *
     * @return void
     */
    public function throw(): void
    {
        throw new $this->getExceptionClass($this->getMessage());
    }
}