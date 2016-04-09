<?php
namespace Application;

use Auth\Middleware\AuthMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix) {
    $app->post(sprintf('%s/auth/{action:sign-in|sign-up|sign-out}[/]', $prefix), AuthMiddleware::class);
    $app->get(sprintf('%s/auth/{action:oauth}/{provider}[/]', $prefix), AuthMiddleware::class);
};