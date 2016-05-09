<?php
use Domain\Feed\Middleware\FeedMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {
    $app->post(
        '/feed/{source:collection}/{collectionId}',
        FeedMiddleware::class,
        'feed-collection'
    );
};