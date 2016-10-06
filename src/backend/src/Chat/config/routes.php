<?php
namespace CASS\Chat;

use CASS\Chat\Middleware\MessageMiddleware;

return [
    'common' =>[
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/protected/chat/message/{command:send}[/]',
            'middleware' => MessageMiddleware::class,
            'name'       => 'chat-message-send'
        ],
    ]
];