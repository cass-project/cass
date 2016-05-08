<?php
namespace Application\Frontline;

use Application\Frontline\Middleware\FrontlineMiddleware;
use Zend\Expressive\Application;

return function (Application $app, string $prefix) {
    $app->get(sprintf('%s/frontline[/]', $prefix), FrontlineMiddleware::class, 'frontline');
};