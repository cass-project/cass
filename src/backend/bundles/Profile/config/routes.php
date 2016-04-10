<?php
namespace Common;

use Profile\Middleware\ProfileMiddleware;
use Zend\Expressive\Application;

return function (Application $app, string $prefix) {
    $app->get(
        sprintf('%s/profile/{id}', $prefix),
        ProfileMiddleware::class,
        'profile-get-by-id'
    );

    $app->put(
        sprintf('%s/protected/profile/{command:create}', $prefix),
        ProfileMiddleware::class,
        'profile-create'
    );

    $app->post(
        sprintf('%s/protected/profile/{command:update}/{id}', $prefix),
        ProfileMiddleware::class,
        'profile-update'
    );

    $app->delete(
        sprintf('%s/protected/profile/{command:delete}/{id}', $prefix),
        ProfileMiddleware::class,
        'profile-delete'
    );
};