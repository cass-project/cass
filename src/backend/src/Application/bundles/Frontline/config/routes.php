<?php
namespace Application\Frontline;

use Application\Frontline\Middleware\FrontlineMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {
    $app->get('/frontline[/]', FrontlineMiddleware::class, 'frontline');
};