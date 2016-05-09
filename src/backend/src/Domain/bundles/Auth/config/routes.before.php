<?php
namespace Domain\Auth;

use Domain\Auth\Middleware\ProtectedMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix) {
    $app->pipe(ProtectedMiddleware::class);
};