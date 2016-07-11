<?php
namespace Domain\Feed;

use Domain\Feed\Middleware\FeedMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->post(
        '/feed/get/{command:profile}/{profileId}[/]',
        FeedMiddleware::class,
        'feed-get-profile'
    );

    $app->post(
        '/feed/get/{command:collection}/{collectionId}[/]',
        FeedMiddleware::class,
        'feed-get-collection'
    );

    array_map(function(string $source) use ($app) {
        $app->post(
            sprintf('/feed/get/{command:%s}[/]', $source),
            FeedMiddleware::class,
            sprintf('feed-get-%s', $source)
        );
    }, [
        'public-profiles',
        'public-experts',
        'public-content',
        'public-discussions',
        'public-communities',
        'public-collections'
    ]);
};