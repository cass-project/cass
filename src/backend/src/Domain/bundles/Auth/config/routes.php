<?php
namespace Domain\Auth;

use Domain\Auth\Middleware\AuthMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->post('/auth/{action:sign-in|sign-up}[/]', AuthMiddleware::class);
    $app->get('/auth/{action:sign-out}[/]', AuthMiddleware::class);
    $app->get('/auth/{action:oauth}/{provider}[/]', AuthMiddleware::class);
};