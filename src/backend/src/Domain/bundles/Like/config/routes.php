<?php
namespace CASS\Domain\Bundles\Like;

use CASS\Domain\Bundles\Like\Middleware\LikeCollectionMiddleware;
use CASS\Domain\Bundles\Like\Middleware\LikeCommunityMiddleware;
use CASS\Domain\Bundles\Like\Middleware\LikePostMiddleware;
use CASS\Domain\Bundles\Like\Middleware\LikeProfileMiddleware;
use CASS\Domain\Bundles\Like\Middleware\LikeThemeMiddleware;

return [

    'common' => [
        // profile
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/like/profile/{profileId}/{command:add-like}[/]',
            'middleware' => LikeProfileMiddleware::class,
            'name'       => 'like-profile-add-like'
        ],
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/like/profile/{profileId}/{command:add-dislike}[/]',
            'middleware' => LikeProfileMiddleware::class,
            'name'       => 'like-profile-add-dislike'
        ],
        [
            'type'       => 'route',
            'method'     => 'delete',
            'url'        => '/like/profile/{profileId}/{command:remove-attitude}[/]',
            'middleware' => LikeProfileMiddleware::class,
            'name'       => 'like-profile-remove-attitude'
        ],
        // theme
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/like/theme/{themeId}/{command:add-like}[/]',
            'middleware' => LikeThemeMiddleware::class,
            'name'       => 'like-theme-add-like'
        ],
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/like/theme/{themeId}/{command:add-dislike}[/]',
            'middleware' => LikeThemeMiddleware::class,
            'name'       => 'like-theme-add-add-dislike'
        ],
        [
            'type'       => 'route',
            'method'     => 'DELETE',
            'url'        => '/like/theme/{themeId}/{command:remove-attitude}[/]',
            'middleware' => LikeThemeMiddleware::class,
            'name'       => 'like-theme-remove-attitude'
        ],
            
        // Community
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/like/community/{communityId}/{command:add-like}[/]',
            'middleware' => LikeCommunityMiddleware::class,
            'name'       => 'like-community-add-like'
        ],
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/like/community/{communityId}/{command:add-dislike}[/]',
            'middleware' => LikeCommunityMiddleware::class,
            'name'       => 'like-community-add-dislike'
        ],

        [
            'type'       => 'route',
            'method'     => 'DELETE',
            'url'        => '/like/community/{communityId}/{command:remove-attitude}[/]',
            'middleware' => LikeCommunityMiddleware::class,
            'name'       => 'like-community-remove-attitude'
        ],

        // Collection
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/like/collection/{collectionId}/{command:add-like}[/]',
            'middleware' => LikeCollectionMiddleware::class,
            'name'       => 'like-collection-add-like'
        ],
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/like/collection/{collectionId}/{command:add-dislike}[/]',
            'middleware' => LikeCollectionMiddleware::class,
            'name'       => 'like-collection-add-dislike'
        ],
        [
            'type'       => 'route',
            'method'     => 'DELETE',
            'url'        => '/like/collection/{collectionId}/{command:remove-attitude}[/]',
            'middleware' => LikeCollectionMiddleware::class,
            'name'       => 'like-collection-remove-attitude'
        ],
        // POST
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/like/post/{postId}/{command:add-like}[/]',
            'middleware' => LikePostMiddleware::class,
            'name'       => 'like-post-add-like'
        ],
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/like/post/{postId}/{command:add-dislike}[/]',
            'middleware' => LikePostMiddleware::class,
            'name'       => 'like-post-add-dislike'
        ],
        [
            'type'       => 'route',
            'method'     => 'DELETE',
            'url'        => '/like/post/{postId}/{command:remove-attitude}[/]',
            'middleware' => LikePostMiddleware::class,
            'name'       => 'like-post-remove-attitude'
        ],

    ]
];