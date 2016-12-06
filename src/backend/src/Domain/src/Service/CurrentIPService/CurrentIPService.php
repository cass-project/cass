<?php

namespace CASS\Domain\Service\CurrentIPService;

class CurrentIPService implements CurrentIPServiceInterface
{
    public function getCurrentIP(): string
    {
        return $_SERVER['REMOTE_ADDR'];
    }
}