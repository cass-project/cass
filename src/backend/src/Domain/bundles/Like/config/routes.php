<?php
namespace CASS\Domain\Bundles\Like;

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

    ]
];