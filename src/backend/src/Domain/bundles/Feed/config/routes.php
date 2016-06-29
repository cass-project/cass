<?php
namespace Domain\Feed;

use Domain\Feed\Middleware\FeedMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {
    $app->post(
        '/feed/{source:collection}/{collectionId}',
        FeedMiddleware::class,
        'feed-collection'
    );

    $app->post(
        '/feed/{source:community}/{communityId}/dashboard[/]',
        FeedMiddleware::class,
        'feed-community'
    );

    $app->post(
        '/feed/{source:profile}/{profileId}/dashboard[/]',
        FeedMiddleware::class,
        'profile-feed-collection'
    );
};