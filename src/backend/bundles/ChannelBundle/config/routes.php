<?php
namespace Application;

use Channel\Middleware\ChannelCRUDMiddleware;
use Zend\Expressive\Application;

return function (Application $app, string $prefix) {
    $app->any(sprintf('%s/protected/channel/{command:create}', $prefix),
              ChannelCRUDMiddleware::class,
              'channel-create'
    );
    $app->any(sprintf('%s/protected/channel/{command:read}', $prefix),
              ChannelCRUDMiddleware::class,
              'channel-read'
    );
};