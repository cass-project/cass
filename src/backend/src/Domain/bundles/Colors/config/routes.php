<?php
namespace CASS\Domain\Bundles\Colors;

use CASS\Domain\Bundles\Colors\Middleware\ColorsMiddleware;

return [
    'common' => [
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/colors/{command:get-colors}[/]',
            'middleware' => ColorsMiddleware::class,
            'name'       => 'colors-get-colors'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/colors/{command:get-palettes}[/]',
            'middleware' => ColorsMiddleware::class,
            'name'       => 'colors-get-palettes'
        ],
    ]
];