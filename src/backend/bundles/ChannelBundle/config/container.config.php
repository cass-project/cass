<?php
namespace Channel;

use Channel\Factory\Middleware\ChannelCRUDMiddlewareFactory;
use Channel\Factory\Service\ChannelServiceFactory;
use Channel\Middleware\ChannelCRUDMiddleware;
use Channel\Service\ChannelService;

return [
    'zend_service_manager' => [
        'factories' => [
            ChannelService::class           => ChannelServiceFactory::class,
            ChannelCRUDMiddleware::class    => ChannelCRUDMiddlewareFactory::class
        ]
    ]
];