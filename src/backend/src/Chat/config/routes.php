<?php
namespace CASS\Chat;

use CASS\Chat\Middleware\MessageMiddleware;

return [
    'common' =>[
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/protected/chat/{command:profile-send}/profile/{profileId}[/]',
            'middleware' => MessageMiddleware::class,
            'name'       => 'chat-profile-send'
        ],
        [
            'type'       => 'route',
            'method'     => 'POST',
            'url'        => '/protected/chat/{command:get-messages}/profile/{profileId}[/]',
            'middleware' => MessageMiddleware::class,
            'name'       => 'chat-profile-get-messages'
        ],
    ]
];