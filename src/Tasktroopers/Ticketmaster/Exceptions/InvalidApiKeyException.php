<?php
namespace Tasktroopers\Ticketmaster\Exceptions;

use Tasktroopers\Ticketmaster\Exceptions\ApiKeyException;

/**
 * Used when API key was provided, but invalid
 */
class InvalidApiKeyException extends ApiKeyException { }