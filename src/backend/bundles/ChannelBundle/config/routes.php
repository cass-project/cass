<?php
namespace Application;

use Channel\Middleware\ChannelCRUDMiddleware;
use Zend\Expressive\Application;

return function (Application $app, string $prefix) {
    $app->get(sprintf('%s/channel/{action}', $prefix), ChannelCRUDMiddleware::class);
//    $app->any(sprintf('%s/channel/{action}', $prefix), AuthMiddleware::class);
};