<?php
namespace CASS\Domain;

use CASS\Domain\Service\CurrentIPService\CurrentIPService;
use CASS\Domain\Service\CurrentIPService\CurrentIPServiceInterface;
use CASS\Domain\Service\CurrentIPService\MockCurrentIPService;
use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        CurrentIPServiceInterface::class => get(CurrentIPService::class),
    ],
    'env' => [
        'test' => [
            CurrentIPServiceInterface::class => get(MockCurrentIPService::class),
        ]
    ]
];