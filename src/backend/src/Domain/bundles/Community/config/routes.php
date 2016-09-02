<?php
namespace CASS\Domain\Bundles\Community;

use CASS\Domain\Bundles\Community\Middleware\CommunityFeaturesMiddleware;
use CASS\Domain\Bundles\Community\Middleware\CommunityMiddleware;

return [
    'common' => [
        [
            'type'       => 'route',
            'method'     => 'put',
            'url'        => '/protected/community/{command:create}[/]',
            'middleware' => CommunityMiddleware::class,
            'name'       => 'community-create'
        ],
        [
            'type'       => 'route',
            'method'     => 'post',
            'url'        => '/protected/community/{communityId}/{command:edit}[/]',
            'middleware' => CommunityMiddleware::class,
            'name'       => 'community-edit'
        ],
        [
            'type'       => 'route',
            'method'     => 'post',
            'url'        => '/protected/community/{communityId}/{command:image-upload}/crop-start/{x1}/{y1}/crop-end/{x2}/{y2}[/]',
            'middleware' => CommunityMiddleware::class,
            'name'       => 'community-image-upload'
        ],
        [
            'type'       => 'route',
            'method'     => 'delete',
            'url'        => '/protected/community/{communityId}/{command:image-delete}[/]',
            'middleware' => CommunityMiddleware::class,
            'name'       => 'community-delete-image'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/community/{communityId}/{command:get}[/]',
            'middleware' => CommunityMiddleware::class,
            'name'       => 'community-get-by-id'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/community/{communityId}/{command:get-by-sid}[/]',
            'middleware' => CommunityMiddleware::class,
            'name'       => 'community-get-by-sid'
        ],
        [
            'type'       => 'route',
            'method'     => 'post',
            'url'        => '/community/{communityId}/{command:set-public-options}[/]',
            'middleware' => CommunityMiddleware::class,
            'name'       => 'community-set-public-options'
        ],
        [
            'type'       => 'route',
            'method'     => 'put',
            'url'        => '/protected/community/{communityId}/feature/{feature}/{command:activate}[/]',
            'middleware' => CommunityFeaturesMiddleware::class,
            'name'       => 'community-feature-activate'
        ],
        [
            'type'       => 'route',
            'method'     => 'delete',
            'url'        => '/protected/community/{communityId}/feature/{feature}/{command:deactivate}[/]',
            'middleware' => CommunityFeaturesMiddleware::class,
            'name'       => 'community-feature-deactivate'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/community/{communityId}/feature/{feature}/{command:is-activated}[/]',
            'middleware' => CommunityFeaturesMiddleware::class,
            'name'       => 'community-feature-is-activated'
        ],
    ]
];