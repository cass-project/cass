<?php
namespace CASS\Application\Swagger;

use CASS\Application\Swagger\Middleware\APIDocsMiddleware;
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
