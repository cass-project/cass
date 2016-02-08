<?php
namespace Application;

use Auth\Middleware\AuthMiddleware;
use Zend\Expressive\Application;

return function(Application $app, $prefix) {
    $app->get(sprintf('%s/auth/{action}', $prefix), AuthMiddleware::class);
};