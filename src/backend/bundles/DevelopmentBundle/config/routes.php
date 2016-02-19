<?php
namespace Development;

use Development\Middleware\DumpConfigMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix) {
    $app->get(sprintf('%s/debug/dump-autoload/app-config/{source}/', $prefix), DumpConfigMiddleware::class);
};