<?php
namespace Domain\Auth;

use Domain\Auth\Middleware\AuthMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->put(
        '/auth/{command:sign-up}[/]',
        AuthMiddleware::class,
        'auth-sign-up'
    );

    $app->post(
        '/auth/{command:sign-in}[/]',
        AuthMiddleware::class,
        'auth-sign-in'
    );

    $app->get(
        '/auth/{command:oauth}/{provider}[/]',
        AuthMiddleware::class,
        'auth-oauth'
    );

    $app->get(
        '/auth/{command:sign-out}[/]',
        AuthMiddleware::class,
        'auth-sign-out'
    );
};