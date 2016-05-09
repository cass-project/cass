<?php
namespace Domain\Auth;

use Domain\Auth\Middleware\ProtectedMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->pipe(ProtectedMiddleware::class);
};