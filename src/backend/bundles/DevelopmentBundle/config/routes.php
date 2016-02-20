<?php
namespace Development;

use Development\Middleware\DumpConfigMiddleware;
use Development\Middleware\APIDocsMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix) {
    $app->get(sprintf('%s/debug/dump-autoload/app-config/{source}/', $prefix), DumpConfigMiddleware::class);
    $app->get(sprintf('%s/debug/api-docs/api-docs.json', $prefix), APIDocsMiddleware::class);
};