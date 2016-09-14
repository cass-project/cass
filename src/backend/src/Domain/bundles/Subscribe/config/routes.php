<?php
namespace CASS\Domain\Bundles\Subscribe;

use CASS\Domain\Bundles\Subscribe\Middleware\SubscribeMiddleware;

return [
    'auth' => [
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/subscribe/{command:subscribe-theme}/{themeId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-theme-subscribe'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/subscribe/{command:unsubscribe-theme}/{themeId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-theme-unsubscribe'
        ],
        // profile
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/subscribe/{command:subscribe-profile}/{profileId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-profile-subscribe'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/subscribe/{command:unsubscribe-profile}/{profileId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-profile-unsubscribe'
        ],
        // collections
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/subscribe/{command:subscribe-collection}/{collectionId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-collection-subscribe'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/subscribe/{command:unsubscribe-collection}/{collectionId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-collection-unsubscribe'
        ],
        // community
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/subscribe/{command:subscribe-community}/{communityId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-community-subscribe'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/subscribe/{command:unsubscribe-community}/{communityId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-community-unsubscribe'
        ],
    ],

    'common' => [
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/subscribe/{command:list-themes}/{profileId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-theme-list'
        ],
        // profile
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/subscribe/{command:list-profiles}/{profileId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-profile-list'
        ],
        // collections
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/subscribe/{command:list-collections}/{collectionId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-collection-list'
        ],
        // community
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/subscribe/{command:list-communities}/{communityId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-community-list'
        ],
    ]
];