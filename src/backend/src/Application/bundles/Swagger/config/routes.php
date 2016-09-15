<?php
namespace CASS\Application\Bundles\Swagger;

use CASS\Application\Bundles\Swagger\Middleware\APIDocsMiddleware;

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
