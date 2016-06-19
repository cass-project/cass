<?php
namespace Domain\Profile;

use Domain\Profile\Middleware\ProfileMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {
    $app->get(
        '/profile/{profileId}/{command:get}[/]',
        ProfileMiddleware::class,
        'profile-get-by-id'
    );

    $app->put(
        '/protected/profile/{command:create}[/]',
        ProfileMiddleware::class,
        'profile-create'
    );

    $app->post(
        '/protected/profile/{profileId}/{command:edit-personal}[/]',
        ProfileMiddleware::class,
        'profile-edit-personal'
    );

    $app->post(
        '/protected/profile/{profileId}/{command:greetings-as}/{method}/[/]',
        ProfileMiddleware::class,
        'profile-greetings-as'
    );

    $app->post(
        '/protected/profile/{profileId}/{command:image-upload}/crop-start/{x1}/{y1}/crop-end/{x2}/{y2}[/]',
        ProfileMiddleware::class,
        'profile-image-upload'
    );

    $app->delete(
        '/protected/profile/{profileId}/{command:image-delete}[/]',
        ProfileMiddleware::class,
        'profile-image-delete'
    );

    $app->delete(
        '/protected/profile/{profileId}/{command:delete}[/]',
        ProfileMiddleware::class,
        'profile-delete'
    );

    $app->put(
        '/protected/profile/{profileId}/{command:expert-in}[/]',
        ProfileMiddleware::class,
        'profile-expert-in-put'
    );

    $app->post(
        '/protected/profile/{profileId}/{command:expert-in}[/]',
        ProfileMiddleware::class,
        'profile-expert-in-post'
    );

    $app->delete(
        '/protected/profile/{profileId}/{command:expert-in}/{theme_ids}',
        ProfileMiddleware::class,
        'profile-expert-in-delete'
    );

    $app->put(
        '/protected/profile/{profileId}/{command:interesting-in}[/]',
        ProfileMiddleware::class,
        'profile-interesting-in-put'
    );

    $app->post(
        '/protected/profile/{profileId}/{command:interesting-in}[/]',
        ProfileMiddleware::class,
        'profile-interesting-in-post'
    );

    $app->delete(
        '/protected/profile/{profileId}/{command:interesting-in}/{theme_ids}[/]',
        ProfileMiddleware::class,
        'profile-interesting-in-delete'
    );

    $app->post(
        '/protected/profile/{profileId}/{command:set-gender}[/]',
        ProfileMiddleware::class,
        'profile-set-gender'
    );
};