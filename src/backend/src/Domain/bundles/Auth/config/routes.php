<?php
namespace Domain\Auth;

use Domain\Auth\Middleware\AuthMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->put(
        '/auth/{action:sign-up}[/]',
        AuthMiddleware::class,
        'auth-sign-up'
    );

    $app->post(
        '/auth/{action:sign-in}[/]',
        AuthMiddleware::class,
        'auth-sign-in'
    );

    $app->get(
        '/auth/sign-in/{action:oauth2}/{provider}[/]',
        AuthMiddleware::class,
        'auth-oauth'
    );

    $app->get(
        '/auth/{action:sign-out}[/]',
        AuthMiddleware::class,
        'auth-sign-out'
    );
};