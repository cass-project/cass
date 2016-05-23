<?php
namespace Domain\ProfileIM;

use Domain\ProfileIM\Middleware\ProfileIMMiddleware;
use Zend\Expressive\Application;

return function (Application $app)
{
    $app->put(
        '/protected/profile-im/{command:send}/to/{targetProfileId}',
        ProfileIMMiddleware::class,
        'profile-im-send'
    );

    $app->get(
        '/protected/profile-im/{command:unread}',
        ProfileIMMiddleware::class,
        'profile-im-unread'
    );

    $app->get(
        '/protected/profile-im/{command:messages}/from/{sourceProfileId}/offset/{offset}/limit/{limit}',
        ProfileIMMiddleware::class,
        'profile-im-messages'
    );
};