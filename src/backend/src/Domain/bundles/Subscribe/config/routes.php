<?php
namespace CASS\Domain\Bundles\Subscribe;

use CASS\Domain\Bundles\Subscribe\Middleware\SubscribeMiddleware;

return [
    'auth' => [
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/protected/subscribe/{command:subscribe-theme}/{themeId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-theme-subscribe'
        ],
        [
            'type'       => 'route',
            'method'     => 'DELETE',
            'url'        => '/protected/subscribe/{command:unsubscribe-theme}/{themeId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-theme-unsubscribe'
        ],
        // profile
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/protected/subscribe/{command:subscribe-profile}/{profileId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-profile-subscribe'
        ],
        [
            'type'       => 'route',
            'method'     => 'DELETE',
            'url'        => '/protected/subscribe/{command:unsubscribe-profile}/{profileId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-profile-unsubscribe'
        ],
        // collections
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/protected/subscribe/{command:subscribe-collection}/{collectionId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-collection-subscribe'
        ],
        [
            'type'       => 'route',
            'method'     => 'DELETE',
            'url'        => '/protected/subscribe/{command:unsubscribe-collection}/{collectionId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-collection-unsubscribe'
        ],
        // community
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/protected/subscribe/{command:subscribe-community}/{communityId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-community-subscribe'
        ],
        [
            'type'       => 'route',
            'method'     => 'DELETE',
            'url'        => '/protected/subscribe/{command:unsubscribe-community}/{communityId}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-community-unsubscribe'
        ],
    ],

    'common' => [
        [
            'type'       => 'route',
            'method'     => 'POST',
            'url'        => '/subscribe/profile/{profileId}/{command:list-themes}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-theme-list'
        ],
        // profile
        [
            'type'       => 'route',
            'method'     => 'POST',
            'url'        => '/subscribe/profile/{profileId}/{command:list-profiles}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-profile-list'
        ],
        // collections
        [
            'type'       => 'route',
            'method'     => 'POST',
            'url'        => '/subscribe/profile/{profileId}/{command:list-collections}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-collection-list'
        ],
        // community
        [
            'type'       => 'route',
            'method'     => 'POST',
            'url'        => '/subscribe/profile/{profileId}/{command:list-communities}[/]',
            'middleware' => SubscribeMiddleware::class,
            'name'       => 'subscribe-community-list'
        ],
    ]
];