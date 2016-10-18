<?php
namespace CASS\Chat;

use CASS\Chat\Middleware\MessageMiddleware;
use CASS\Chat\Middleware\RoomMiddleware;

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
            'method'     => 'PUT',
            'url'        => '/protected/chat/{command:profile-send-profile}/source-profile/{sourceId}/target-profile/{targetId}[/]',
            'middleware' => MessageMiddleware::class,
            'name'       => 'chat-profile-profile'
        ],
        [
            'type'       => 'route',
            'method'     => 'POST',
            'url'        => '/protected/chat/{command:get-messages}/profile/{profileId}[/]',
            'middleware' => MessageMiddleware::class,
            'name'       => 'chat-profile-get-messages'
        ],


        // создаём комнату
        [
            'type'      => 'route',
            'method'    => 'PUT',
            'url'       => '/protected/chat/room/{command:create}',
            'middleware'=> RoomMiddleware::class,
            'name'      => 'chat-room-create'
        ]
        // Удаляем комнату
        // Добавляем пользователей в комнату
    ]
];