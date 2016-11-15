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


    ]
];