<?php
namespace Domain\Profile;

use Domain\Profile\Middleware\ProfileMiddleware;
use Zend\Expressive\Application;

return function (Application $app, string $prefix) {
    $app->get(
        sprintf('%s/profile/{profileId}/{command:get}[/]', $prefix),
        ProfileMiddleware::class,
        'profile-get-by-id'
    );

    $app->put(
        sprintf('%s/protected/profile/{command:create}/{accountId}[/]', $prefix),
        ProfileMiddleware::class,
        'profile-create'
    );

    $app->post(
        sprintf('%s/protected/profile/{profileId}/{command:edit-personal}[/]', $prefix),
        ProfileMiddleware::class,
        'profile-edit-personal'
    );

    $app->post(
        sprintf('%s/protected/profile/{profileId}/{command:switch}[/]', $prefix),
        ProfileMiddleware::class,
        'profile-switch'
    );

    $app->post(
        sprintf('%s/protected/profile/{profileId}/{command:greetings-as}/{greetingsMethod}/[/]', $prefix),
        ProfileMiddleware::class,
        'profile-greetings-as'
    );

    $app->post(
        sprintf('%s/protected/profile/{profileId}/{command:image-upload}/crop-start/{x1}/{y1}/crop-end/{x2}/{y2}[/]', $prefix),
        ProfileMiddleware::class,
        'profile-image-upload'
    );

    $app->delete(
        sprintf('%s/protected/profile/{profileId}/{command:delete}[/]', $prefix),
        ProfileMiddleware::class,
        'profile-delete'
    );

    $app->put(
        sprintf('%s/protected/profile/{profileId}/{command:expert-in}[/]', $prefix),
        ProfileMiddleware::class,
        'profile-expert-in-put'
    );

    $app->post(
        sprintf('%s/protected/profile/{profileId}/{command:expert-in}[/]', $prefix),
        ProfileMiddleware::class,
        'profile-expert-in-post'
    );

    $app->delete(
        sprintf('%s/protected/profile/{profileId}/{command:expert-in}/{theme_ids}', $prefix),
        ProfileMiddleware::class,
        'profile-expert-in-delete'
    );

    $app->put(
        sprintf('%s/protected/profile/{profileId}/{command:interesting-in}[/]', $prefix),
        ProfileMiddleware::class,
        'profile-interesting-in-put'
    );

    $app->post(
      sprintf('%s/protected/profile/{profileId}/{command:interesting-in}[/]', $prefix),
      ProfileMiddleware::class,
      'profile-interesting-in-post'
    );

    $app->delete(
        sprintf('%s/protected/profile/{profileId}/{command:interesting-in}/{theme_ids}', $prefix),
        ProfileMiddleware::class,
        'profile-interesting-in-delete'
    );
};