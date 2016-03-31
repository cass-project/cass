<?php
namespace Application;

use Feed\Middleware\FeedMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix) {
    $app->get(sprintf('%s/feed/{command:search}/{text}', $prefix), FeedMiddleware::class, 'feed-search-entity');
};