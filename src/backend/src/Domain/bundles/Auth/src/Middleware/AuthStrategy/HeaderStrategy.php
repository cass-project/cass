<?php
namespace Domain\Auth\Middleware\AuthStrategy;

use CASS\Application\Auth\Exception\APIKeyIsNotAvailableException;

class HeaderStrategy extends Strategy
{
    const HEADER_API_KEY = 'Authorization';

    public function isAPIKeyAvailable(): bool
    {
        return $this->request->hasHeader(self::HEADER_API_KEY);
    }

    public function getAPIKey()
    {
        if(!$this->isAPIKeyAvailable()) {
            throw new APIKeyIsNotAvailableException;
        }

        return $this->request->getHeader(self::HEADER_API_KEY)[0];
    }
}