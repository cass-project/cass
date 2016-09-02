<?php
namespace CASS\Domain\Bundles\ProfileCommunities;

use CASS\Domain\Bundles\ProfileCommunities\Middleware\ProfileCommunitiesMiddleware;

return [
    'common' => [
        [
            'type'       => 'route',
            'method'     => 'put',
            'url'        => '/protected/with-profile/{profileId}/community/{communitySID}/{command:join}[/]',
            'middleware' => ProfileCommunitiesMiddleware::class,
            'name'       => 'profile-communities-join'
        ],
        [
            'type'       => 'route',
            'method'     => 'delete',
            'url'        => '/protected/with-profile/{profileId}/community/{communitySID}/{command:leave}[/]',
            'middleware' => ProfileCommunitiesMiddleware::class,
            'name'       => 'profile-communities-leave'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/with-profile/{profileId}/community/list/{command:joined-communities}[/]',
            'middleware' => ProfileCommunitiesMiddleware::class,
            'name'       => 'profile-communities-list'
        ],
    ]
];