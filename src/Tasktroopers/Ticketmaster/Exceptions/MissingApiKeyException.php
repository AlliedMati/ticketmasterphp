<?php
namespace Tasktroopers\Ticketmaster\Exceptions;

use Tasktroopers\Ticketmaster\Exceptions\ApiKeyException;

/**
 * Used when no API key parameter was provided at all
 */
class MissingApiKeyException extends ApiKeyException { }