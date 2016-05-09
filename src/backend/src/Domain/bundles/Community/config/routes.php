<?php
namespace Domain\Community;

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

    $app->get(
        '/community/{communityId}/{command:get}[/]',
        CommunityMiddleware::class,
        'community-get-by-id'
    );
};