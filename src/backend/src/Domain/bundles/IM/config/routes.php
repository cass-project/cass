<?php
namespace Domain\IM;

use Domain\IM\Middleware\ProfileIMMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->put(
        '/protected/with-profile/{targetProfileId}/profile-im/messages/from/{sourceProfileId}[/]',
        ProfileIMMiddleware::class,
        'profile-im-send'
    );

    $app->get(
        '/protected/with-profile/{targetProfileId}/profile-im/messages/unread[/]',
        ProfileIMMiddleware::class,
        'profile-im-unread'
    );

    $app->post(
        '/protected/with-profile/{targetProfileId}/profile-im/messages/from/{sourceProfileId}[/]',
        ProfileIMMiddleware::class,
        'profile-im-messages'
    );
};