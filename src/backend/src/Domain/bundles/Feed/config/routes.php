<?php
namespace CASS\Domain\Bundles\Feed;

use CASS\Domain\Bundles\Feed\Middleware\FeedMiddleware;

return [
    'common' => [
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/feed/get/{command:profile}/{profileId}[/]',
            'middleware' => FeedMiddleware::class,
            'name' => 'feed-get-profile',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/feed/get/{command:collection}/{collectionId}[/]',
            'middleware' => FeedMiddleware::class,
            'name' => 'feed-get-collection',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/feed/get/{command:community}/{communityId}[/]',
            'middleware' => FeedMiddleware::class,
            'name' => 'feed-get-community',
        ],

        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/feed/get/{command:public-profiles}[/]',
            'middleware' => FeedMiddleware::class,
            'name' => 'feed-get-public-profiles',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/feed/get/{command:public-experts}[/]',
            'middleware' => FeedMiddleware::class,
            'name' => 'feed-get-public-experts',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/feed/get/{command:public-content}[/]',
            'middleware' => FeedMiddleware::class,
            'name' => 'feed-get-public-content',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/feed/get/{command:public-discussions}[/]',
            'middleware' => FeedMiddleware::class,
            'name' => 'feed-get-public-discussions',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/feed/get/{command:public-communities}[/]',
            'middleware' => FeedMiddleware::class,
            'name' => 'feed-get-public-communities',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/feed/get/{command:public-collections}[/]',
            'middleware' => FeedMiddleware::class,
            'name' => 'feed-get-public-collections',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/feed/get/{command:personal-themes}[/]',
            'middleware' => FeedMiddleware::class,
            'name' => 'feed-get-personal-themes',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/feed/get/{command:personal-communities}[/]',
            'middleware' => FeedMiddleware::class,
            'name' => 'feed-get-personal-communities',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/feed/get/{command:personal-collections}[/]',
            'middleware' => FeedMiddleware::class,
            'name' => 'feed-get-personal-collections',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/feed/get/{command:personal-people}[/]',
            'middleware' => FeedMiddleware::class,
            'name' => 'feed-get-personal-people',
        ],
    ],
];