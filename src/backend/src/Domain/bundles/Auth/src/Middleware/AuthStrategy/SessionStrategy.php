<?php
namespace CASS\Domain\Auth\Middleware\AuthStrategy;

use CASS\Application\Auth\Exception\APIKeyIsNotAvailableException;

class SessionStrategy extends Strategy
{
    const SESSION_API_KEY = 'api_key';

    public function isAPIKeyAvailable(): bool
    {
        return isset($_SESSION[self::SESSION_API_KEY]);
    }

    public function getAPIKey()
    {
        if(!$this->isAPIKeyAvailable()) {
            throw new APIKeyIsNotAvailableException;
        }

        return $_SESSION[self::SESSION_API_KEY];
    }
}