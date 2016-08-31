<?php
namespace CASS\Application;

use ZEA2\Platform\Bundles\Swagger\Middleware\APIDocsMiddleware;

return [
    'common' => [
        [
            'type' => 'route',
            'method' => 'get',
            'url' => '/api-docs.json',
            'middleware' => APIDocsMiddleware::class,
            'name' => 'api-docs',
        ],
    ],
];
