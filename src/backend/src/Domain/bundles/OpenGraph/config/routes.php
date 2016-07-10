<?php
namespace Domain\OpenGraph;

use Domain\OpenGraph\Middleware\OpenGraphMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {
  $app->get(
        '/opg/get-opg[/]',
        OpenGraphMiddleware::class,
        'opg-get-opg'
    );
};