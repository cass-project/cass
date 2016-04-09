<?php
namespace Auth;

use Account\Factory\Service\AccountServiceFactory;
use Account\Service\AccountService;

return [
    'zend_service_manager' => [
        'factories' => [
            AccountService::class => AccountServiceFactory::class
        ]
    ]
];