<?php
namespace Application\Auth\Middleware\AuthStrategy;

use Application\Auth\Exception\APIKeyIsNotAvailableException;

class HeaderStrategy extends Strategy
{
    const HEADER_API_KEY = 'X-Api-Key';

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