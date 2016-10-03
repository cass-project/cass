<?php
namespace CASS\Chat\Bundles\Contact;

use CASS\Chat\Bundles\Contact\Middleware\ContactMiddleware;

return [
    'common' => [
        // list
        [
            'type'       => 'route',
            'method'     => 'GET',
            'url'        => '/protected/chat/contact/{command:list}[/]',
            'middleware' => ContactMiddleware::class,
            'name'       => 'chat-contact-list'
        ],
        // add
        [
            'type'       => 'route',
            'method'     => 'PUT',
            'url'        => '/protected/chat/contact/{command:add}[/]',
            'middleware' => ContactMiddleware::class,
            'name'       => 'chat-contact-add'
        ],
        // delete
        [
            'type'       => 'route',
            'method'     => 'DELETE',
            'url'        => '/protected/chat/contact/{command:remove}/{contactId}[/]',
            'middleware' => ContactMiddleware::class,
            'name'       => 'chat-contact-remove'
        ],

    ]
];