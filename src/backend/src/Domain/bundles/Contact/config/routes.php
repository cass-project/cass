<?php
namespace CASS\Domain\Contact;

use CASS\Domain\Contact\Middleware\ContactMiddleware;

return [
    'common' => [
        [
            'type'       => 'route',
            'method'     => 'put',
            'url'        => '/protected/profile/{profileId}/contact/{command:create}[/]',
            'middleware' => ContactMiddleware::class,
            'name'       => 'contact-create'
        ],
        [
            'type'       => 'route',
            'method'     => 'delete',
            'url'        => '/protected/profile/{profileId}/contact/{contactId}/{command:delete}[/]',
            'middleware' => ContactMiddleware::class,
            'name'       => 'contact-delete'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/profile/{profileId}/contact/{contactId}/{command:get}[/]',
            'middleware' => ContactMiddleware::class,
            'name'       => 'contact-get'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/profile/{profileId}/contact/{command:list}[/]',
            'middleware' => ContactMiddleware::class,
            'name'       => 'contact-list'
        ],
        [
            'type'       => 'route',
            'method'     => 'post',
            'url'        => '/protected/profile/{profileId}/contact/{contactId}/{command:set-permanent}[/]',
            'middleware' => ContactMiddleware::class,
            'name'       => 'contact-set-permanent'
        ],
    ]
];