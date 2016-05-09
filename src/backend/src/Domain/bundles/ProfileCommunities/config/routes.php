<?php
namespace Domain\ProfileCommunities;

use Domain\ProfileCommunities\Middleware\ProfileCommunitiesMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->put(
        '/protected/community/{communityId}/{command:join}',
        ProfileCommunitiesMiddleware::class,
        'profile-communities-join'
    );

    $app->delete(
        '/protected/community/{communityId}/{command:leave}',
        ProfileCommunitiesMiddleware::class,
        'profile-communities-leave'
    );

    $app->get(
        '/protected/profile/current/{command:joined-communities}',
        ProfileCommunitiesMiddleware::class,
        'profile-communities-list'
    );
};