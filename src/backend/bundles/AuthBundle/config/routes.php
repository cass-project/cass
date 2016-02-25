<?php
namespace Application;

use Auth\Middleware\AuthMiddleware;
use Auth\Middleware\HeadersMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix) {
    $app->pipe(HeadersMiddleware::class);
    $app->get(sprintf('%s/auth/{action}', $prefix), AuthMiddleware::class);
    $app->post(sprintf('%s/auth/{action}', $prefix), AuthMiddleware::class);
    $app->get(sprintf('%s/auth/{action}/{provider}', $prefix), AuthMiddleware::class);
};