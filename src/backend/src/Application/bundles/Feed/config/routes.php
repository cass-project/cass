<?php
use Application\Feed\Middleware\FeedMiddleware;
use Zend\Expressive\Application;

return function (Application $app, string $prefix) {
    $app->post(
        sprintf('%s/feed/{source:collection}/{collectionId}', $prefix),
        FeedMiddleware::class,
        'feed-collection'
    );
};