<?php
namespace Domain\OpenGraph;

use Domain\OpenGraph\Middleware\OpenGraphMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {
  $app->get(
        '/og/get-og[/]',
        OpenGraphMiddleware::class,
        'og-get-og'
    );
};