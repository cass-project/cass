<?php
use Collection\Middleware\CollectionMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix) {
    $app->put(
        sprintf('%s/protected/profile/{profileId}/collection/{command:create}', $prefix),
        CollectionMiddleware::class,
        'collection-create'
    );

    $app->delete(
        sprintf('%s/protected/profile/{profileId}/collection/{collectionId}/{command:delete}', $prefix),
        CollectionMiddleware::class,
        'collection-delete'
    );

    $app->get(
        sprintf('%s/protected/profile/{profileId}/collection/{command:list}', $prefix),
        CollectionMiddleware::class,
        'collection-list'
    );

    $app->get(
        sprintf('%s/protected/profile/{profileId}/collection/{command:tree}', $prefix),
        CollectionMiddleware::class,
        'collection-tree'
    );

    $app->post(
        sprintf('%s/protected/collection/{command:move}/{collectionId}/under/{collectionParentId}/in-position/{position}', $prefix),
        CollectionMiddleware::class,
        'collection-move'
    );

    $app->put(
        sprintf('%s/protected/collection/{command:update}/{collectionId}', $prefix),
        CollectionMiddleware::class,
        'collection-update'
    );
};