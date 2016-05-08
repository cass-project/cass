<?php
namespace Domain\Auth;

use Domain\Auth\Middleware\AuthMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix) {
    $app->post(sprintf('%s/auth/{action:sign-in|sign-up}[/]', $prefix), AuthMiddleware::class);
    $app->get(sprintf('%s/auth/{action:sign-out}[/]', $prefix), AuthMiddleware::class);
    $app->get(sprintf('%s/auth/{action:oauth}/{provider}[/]', $prefix), AuthMiddleware::class);
};