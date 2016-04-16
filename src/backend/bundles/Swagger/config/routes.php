<?php
use Swagger\Middleware\APIDocsMiddleware;
use Zend\Expressive\Application;

return function (Application $app, string $prefix) {
    $app->get(sprintf('%s/api-docs.json', $prefix), APIDocsMiddleware::class);
};