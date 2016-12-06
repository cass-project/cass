<?php

namespace CASS\Domain\Service\CurrentIPService;

interface CurrentIPServiceInterface
{
    function getCurrentIP(): string;
}