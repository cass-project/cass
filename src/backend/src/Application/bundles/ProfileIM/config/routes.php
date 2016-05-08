<?php
namespace Application\ProfileIM;

use Application\ProfileIM\Middleware\ProfileIMMiddleware;
use Zend\Expressive\Application;

return function (Application $app, string $prefix)
{
    $app->put(
        sprintf('%s/protected/profile-im/{command:send}/to/{targetProfileId}', $prefix),
        ProfileIMMiddleware::class,
        'profile-im-send'
    );

    $app->get(
        sprintf('%s/protected/profile-im/{command:unread}',  $prefix),
        ProfileIMMiddleware::class,
        'profile-im-unread'
    );

    $app->get(
        sprintf('%s/protected/profile-im/{command:messages}/from/{sourceProfileId}/offset/{offset}/limit/{limit}', $prefix),
        ProfileIMMiddleware::class,
        'profile-im-messages'
    );
};