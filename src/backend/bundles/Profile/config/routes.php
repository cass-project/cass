<?php
namespace Common;

use Profile\Middleware\ProfileMiddleware;
use Zend\Expressive\Application;

return function (Application $app, string $prefix) {
    $app->get(
        sprintf('%s/profile/{profileId}/{command:get}[/]', $prefix),
        ProfileMiddleware::class,
        'profile-get-by-id'
    );

    $app->put(
        sprintf('%s/protected/profile/{command:create}[/]', $prefix),
        ProfileMiddleware::class,
        'profile-create'
    );

    $app->post(
        sprintf('%s/protected/profile/{profileId}/{command:update}[/]', $prefix),
        ProfileMiddleware::class,
        'profile-update'
    );

    $app->post(
        sprintf('%s/protected/profile/{profileId}/{command:greetings-as}/{greetingsType}/[/]', $prefix),
        ProfileMiddleware::class,
        'profile-greetings-as'
    );

    $app->post(
        sprintf('%s/protected/profile/{profileId}/{command:image-upload}/[/]', $prefix),
        ProfileMiddleware::class,
        'profile-image-upload'
    );

    $app->delete(
        sprintf('%s/protected/profile/{profileId}/{command:delete}[/]', $prefix),
        ProfileMiddleware::class,
        'profile-delete'
    );
};