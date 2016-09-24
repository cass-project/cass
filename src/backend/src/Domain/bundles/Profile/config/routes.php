<?php
namespace CASS\Domain\Bundles\Profile;

use CASS\Domain\Bundles\Profile\Middleware\ProfileMiddleware;

return [
    'common' => [
        [
            'type' => 'route',
            'method' => 'get',
            'url' => '/profile/{profileId}/{command:get}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-get-by-id',
        ],
        [
            'type' => 'route',
            'method' => 'get',
            'url' => '/profile/{command:by-sid}/{sid}/get[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-get-by-sid',
        ],
        [
            'type' => 'route',
            'method' => 'put',
            'url' => '/protected/profile/{command:create}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-create',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/profile/{profileId}/{command:edit-personal}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-edit-personal',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/profile/{profileId}/{command:greetings-as}/{method}/[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-greetings-as',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/profile/{profileId}/{command:image-upload}/crop-start/{x1}/{y1}/crop-end/{x2}/{y2}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-image-upload',
        ],
        [
            'type' => 'route',
            'method' => 'delete',
            'url' => '/protected/profile/{profileId}/{command:image-delete}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-image-delete',
        ],
        [
            'type' => 'route',
            'method' => 'delete',
            'url' => '/protected/profile/{profileId}/{command:delete}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-delete',
        ],
        [
            'type' => 'route',
            'method' => 'put',
            'url' => '/protected/profile/{profileId}/{command:expert-in}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-expert-in-put',
        ],
        [
            'type' => 'route',
            'method' => 'put',
            'url' => '/protected/profile/{profileId}/{command:interesting-in}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-interesting-in-put',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/profile/{profileId}/{command:set-gender}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-set-gender',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/profile/{profileId}/{command:birthday}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-set-birthday',
        ],
        [
            'type' => 'route',
            'method' => 'delete',
            'url' => '/protected/profile/{profileId}/{command:birthday}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-unset-birthday',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/profile/{profileId}/{command:backdrop-upload}/textColor/{textColor}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-backdrop-upload',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/profile/{profileId}/{command:backdrop-none}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-backdrop-none',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/profile/{profileId}/{command:backdrop-preset}/presetId/{presetId}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-backdrop-preset',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/profile/{profileId}/{command:backdrop-color}/code/{code}[/]',
            'middleware' => ProfileMiddleware::class,
            'name' => 'profile-backdrop-color',
        ]
    ],
];