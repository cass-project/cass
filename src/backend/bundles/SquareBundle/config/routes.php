<?php
namespace Square;

use Square\Middleware\CalculateSquare\CalculateSquareMiddleware;
use Zend\Expressive\Application;

return function(Application $app, $prefix) {
    $app->get(sprintf('%s/square/calculate/{input}', $prefix), CalculateSquareMiddleware::class);
};