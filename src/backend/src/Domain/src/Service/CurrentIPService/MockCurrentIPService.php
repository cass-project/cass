<?php

namespace CASS\Domain\Service\CurrentIPService;

class MockCurrentIPService implements CurrentIPServiceInterface
{
    function getCurrentIP(): string
    {
       return '127.0.0.1';
    }

}