<?php
namespace Domain\Contact;

use Domain\Contact\Middleware\ContactMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->put(
        '/protected/profile/{profileId}/contact/{command:create}[/]',
        ContactMiddleware::class,
        'contact-create'
    );

    $app->delete(
        '/protected/profile/{profileId}/contact/{contactId}/{command:delete}[/]',
        ContactMiddleware::class,
        'contact-delete'
    );

    $app->get(
        '/protected/profile/{profileId}/contact/{contactId}/{command:get}[/]',
        ContactMiddleware::class,
        'contact-get'
    );

    $app->get(
        '/protected/profile/{profileId}/contact/{command:list}[/]',
        ContactMiddleware::class,
        'contact-list'
    );

    $app->post(
        '/protected/profile/{profileId}/contact/{contactId}/{command:set-permanent}[/]',
        ContactMiddleware::class,
        'contact-set-permanent'
    );
};