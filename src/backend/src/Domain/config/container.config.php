<?php
namespace CASS\Domain;

use CASS\Domain\Service\CurrentIPService\CurrentIPService;
use CASS\Domain\Service\CurrentIPService\CurrentIPServiceInterface;
use CASS\Domain\Service\CurrentIPService\MockCurrentIPService;
use function DI\object;
use function DI\factory;
use function DI\get;

$configDefault = [
    'php-di' => [
        CurrentIPServiceInterface::class => get(CurrentIPService::class),
    ],
];

$configMock = [
    'php-di' => [
        CurrentIPServiceInterface::class => get(MockCurrentIPService::class),
    ],
];

return [
    'php-di' => [

    ],

    'env' => [
        'development' => $configDefault,
        'production' => $configDefault,
        'stage' => $configDefault,
        'test' => $configMock,
    ],
];