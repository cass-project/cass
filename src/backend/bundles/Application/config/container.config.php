<?php
use Application\Factory\Service\SchemaServiceFactory;
use Application\Factory\Service\TransactionServiceFactory;
use Application\Service\SchemaService;
use Application\Service\TransactionService;

return [
    'zend_service_manager' => [
        'factories' => [
            SchemaService::class => SchemaServiceFactory::class,
            TransactionService::class => TransactionServiceFactory::class
        ]
    ]
];