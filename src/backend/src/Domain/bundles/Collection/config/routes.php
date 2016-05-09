<?php
namespace Domain\Collection;

use Domain\Collection\Middleware\CollectionMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->put(
        '/protected/profile/{profileId}/collection/{command:create}',
        CollectionMiddleware::class,
        'collection-create'
    );

    $app->delete(
        '/protected/profile/{profileId}/collection/{collectionId}/{command:delete}',
        CollectionMiddleware::class,
        'collection-delete'
    );

    $app->get(
        '/protected/profile/{profileId}/collection/{command:list}',
        CollectionMiddleware::class,
        'collection-list'
    );

    $app->get(
        '/protected/profile/{profileId}/collection/{command:tree}',
        CollectionMiddleware::class,
        'collection-tree'
    );

    $app->post(
        '/protected/collection/{command:move}/{collectionId}/under/{collectionParentId}/in-position/{position}',
        CollectionMiddleware::class,
        'collection-move'
    );

    $app->put(
        '/protected/collection/{command:update}/{collectionId}',
        CollectionMiddleware::class,
        'collection-update'
    );
};