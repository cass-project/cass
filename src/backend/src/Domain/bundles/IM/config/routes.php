<?php
namespace Domain\IM;

use Domain\IM\Middleware\ProfileIMMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->put(
        '/protected/with-profile/{sourceProfileId}/im/{command:send}/to/{source}/{sourceId}[/]',
        ProfileIMMiddleware::class,
        'profile-im-send'
    );

    $app->get(
        '/protected/with-profile/{targetProfileId}/im/{command:unread}[/]',
        ProfileIMMiddleware::class,
        'profile-im-unread'
    );

    $app->post(
        '/protected/with-profile/{targetProfileId}/im/{command:messages}/{source}/{sourceId}[/]',
        ProfileIMMiddleware::class,
        'profile-im-messages'
    );
};