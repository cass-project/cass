<?php
namespace Application;

use Channel\Middleware\ChannelCRUDMiddleware;
use Zend\Expressive\Application;

return function (Application $app, string $prefix) {
    $app->put(sprintf('%s/protected/channel/{command:create}', $prefix),
              ChannelCRUDMiddleware::class,
              'channel-create'
    );

    $app->get(sprintf('%s/protected/channel/{command:read}', $prefix),
              ChannelCRUDMiddleware::class,
              'channel-read'
    );

    $app->get(sprintf('%s/protected/channel/{command:read}/{channelId}', $prefix),
              ChannelCRUDMiddleware::class,
              'channel-read-entity'
    );

    $app->delete(sprintf('%s/protected/channel/{command:delete}/{channelId}', $prefix),
              ChannelCRUDMiddleware::class,
              'channel-delete-entity'
    );

    $app->post(sprintf('%s/protected/channel/{command:update}/{channelId}', $prefix),
              ChannelCRUDMiddleware::class,
              'channel-update-entity'
    );
};