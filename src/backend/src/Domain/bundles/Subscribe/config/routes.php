<?php
namespace CASS\Domain\Bundles\Subscribe;

use CASS\Domain\Bundles\Subscribe\Middleware\SubscribeMiddleware;

return [
    'common' => [
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/subscribe/{command:subscribe-theme}/{themeId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-theme-subscribe'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/subscribe/{command:unsubscribe-theme}/{themeId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-theme-unsubscribe'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/subscribe/theme/{profileId}/{command:list-themes}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-theme-list'
        ],
    ]
];