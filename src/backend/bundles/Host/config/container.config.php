<?php
namespace Host;

use Host\Factory\Service\CurrentHostServiceFactory;
use Host\Service\CurrentHostService;

return [
    'zend_service_manager' => [
        'factories' => [
            CurrentHostService::class => CurrentHostServiceFactory::class
        ]
    ]
];