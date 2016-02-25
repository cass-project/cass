<?php
use Application\Factory\Service\SchemaServiceFactory;
use Application\Service\SchemaService;

return [
    'zend_service_manager' => [
        'factories' => [
            SchemaService::class => SchemaServiceFactory::class
        ]
    ]
];