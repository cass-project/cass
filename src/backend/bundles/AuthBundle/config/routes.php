<?php
namespace Application;

use Auth\Middleware\AuthMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix) {
    $app->get(sprintf('%s/auth/{action}', $prefix), AuthMiddleware::class);
    $app->get(sprintf('%s/auth/{action}/{provider}', $prefix), AuthMiddleware::class);
};