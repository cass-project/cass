<?php
namespace Domain\Collection;

use Domain\Collection\Middleware\CollectionMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->put(
        '/protected/{source:profile|community}/{sourceId}/collection/{command:create}',
        CollectionMiddleware::class,
        'collection-create'
    );

    $app->delete(
        '/protected/collection/{collectionId}/{command:delete}',
        CollectionMiddleware::class,
        'collection-delete'
    );

    $app->post(
        '/protected/collection/{collectionId}/{command:edit}',
        CollectionMiddleware::class,
        'collection-edit'
    );
};