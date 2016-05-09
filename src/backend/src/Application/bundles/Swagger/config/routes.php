<?php
namespace Application\Swagger;

use Application\Swagger\Middleware\APIDocsMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {
    $app->get('/api-docs.json', APIDocsMiddleware::class);
};