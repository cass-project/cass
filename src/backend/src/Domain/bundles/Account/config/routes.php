<?php
namespace Domain\Post;

use Domain\Account\Middleware\AccountMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {
    $app->post(
        '/protected/account/{command:change-password}',
        AccountMiddleware::class,
        'account-change-password'
    );

    $app->put(
        '/protected/account/{command:request-delete}',
        AccountMiddleware::class,
        'account-request-delete'
    );

    $app->delete(
        '/protected/account/{command:cancel-request-delete}',
        AccountMiddleware::class,
        'account-cancel-request-delete'
    );

    $app->post(
        '/protected/account/{command:switch}/to/profile/{profileId}',
        AccountMiddleware::class,
        'account-switch-to-profile'
    );

    $app->get(
        '/protected/account/{command:current}',
        AccountMiddleware::class,
        'account-get-current'
    );
};