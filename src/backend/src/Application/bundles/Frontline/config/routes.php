<?php
namespace CASS\Application\Bundles\Frontline;

use CASS\Application\Bundles\Frontline\Middleware\FrontlineMiddleware;

return [
    'common' => [
        [
            'type' => 'route',
            'method' => 'get',
            'url' => '/frontline/{tags}[/]',
            'middleware' => FrontlineMiddleware::class,
            'name' => 'frontline',
        ],
    ],
];