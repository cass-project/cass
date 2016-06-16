<?php
namespace Domain\Community;

use Domain\Community\Middleware\CommunityFeaturesMiddleware;
use Domain\Community\Middleware\CommunityMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->put(
        '/protected/community/{command:create}[/]',
        CommunityMiddleware::class,
        'community-create'
    );

    $app->post(
        '/protected/community/{communityId}/{command:edit}[/]',
        CommunityMiddleware::class,
        'community-edit'
    );

    $app->post(
        '/protected/community/{communityId}/{command:image-upload}/crop-start/{x1}/{y1}/crop-end/{x2}/{y2}[/]',
        CommunityMiddleware::class,
        'community-image-upload'
    );

    $app->delete(
        '/protected/community/{communityId}/{command:image-delete}[/]',
        CommunityMiddleware::class,
        'community-delete-image'
    );

    $app->get(
        '/community/{communityId}/{command:get}[/]',
        CommunityMiddleware::class,
        'community-get-by-id'
    );

    $app->get(
        '/community/{communityId}/{command:get-by-sid}[/]',
        CommunityMiddleware::class,
        'community-get-by-sid'
    );

    $app->post(
        '/community/{communityId}/{command:set-public-options}[/]',
        CommunityMiddleware::class,
        'community-set-public-options'
    );

    $app->put(
        '/protected/community/{communityId}/feature/{feature}/{command:activate}[/]',
        CommunityFeaturesMiddleware::class,
        'community-feature-activate'
    );

    $app->delete(
        '/protected/community/{communityId}/feature/{feature}/{command:deactivate}[/]',
        CommunityFeaturesMiddleware::class,
        'community-feature-deactivate'
    );

    $app->get(
        '/protected/community/{communityId}/feature/{feature}/{command:is-activated}[/]',
        CommunityFeaturesMiddleware::class,
        'community-feature-is-activated'
    );
};