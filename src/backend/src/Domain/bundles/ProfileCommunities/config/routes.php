<?php
namespace Domain\ProfileCommunities;

use Domain\ProfileCommunities\Middleware\ProfileCommunitiesMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->put(
        '/protected/with-profile/{profileId}/community/{communitySID}/{command:join}[/]',
        ProfileCommunitiesMiddleware::class,
        'profile-communities-join'
    );

    $app->delete(
        '/protected/with-profile/{profileId}/community/{communitySID}/{command:leave}[/]',
        ProfileCommunitiesMiddleware::class,
        'profile-communities-leave'
    );

    $app->get(
        '/protected/with-profile/{profileId}/community/list/{command:joined-communities}[/]',
        ProfileCommunitiesMiddleware::class,
        'profile-communities-list'
    );
};