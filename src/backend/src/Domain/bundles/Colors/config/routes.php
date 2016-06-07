<?php
namespace Domain\Colors;

use Domain\Colors\Middleware\ColorsMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->get(
        '/colors/{command:get-colors}[/]',
        ColorsMiddleware::class,
        'colors-get-colors'
    );

    $app->get(
        '/colors/{command:get-palettes}[/]',
        ColorsMiddleware::class,
        'colors-get-palettes'
    );
};