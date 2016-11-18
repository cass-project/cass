<?php
namespace CASS\Domain\Bundles\Like;

use CASS\Domain\Bundles\Like\Middleware\LikeProfileMiddleware;

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

    ]
];