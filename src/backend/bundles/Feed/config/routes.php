<?php
namespace Common;

use Feed\Middleware\FeedMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix) {
    $app->post(sprintf('%s/feed/', $prefix), FeedMiddleware::class, 'feed-entity');
    $app->get(sprintf('%s/feed/{command:search}/{text}', $prefix), FeedMiddleware::class, 'feed-search-entity');
};