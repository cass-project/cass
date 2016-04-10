<?php
use Common\Factory\Service\SchemaServiceFactory;
use Common\Factory\Service\TransactionServiceFactory;
use Common\Service\SchemaService;
use Common\Service\TransactionService;

return [
    'zend_service_manager' => [
        'factories' => [
            SchemaService::class => SchemaServiceFactory::class,
            TransactionService::class => TransactionServiceFactory::class
        ]
    ]
];