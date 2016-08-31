<?php
namespace ZEA2\Platform\Bundles\Swagger;

use ZEA2\Platform\Bundles\Swagger\Middleware\APIDocsMiddleware;
use Zend\Expressive\Application;

return [
    'common' => [
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/api-docs.json',
            'middleware' => APIDocsMiddleware::class,
            'name'       => 'api-docs'
        ],
    ]
];
