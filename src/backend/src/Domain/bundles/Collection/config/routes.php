<?php
namespace Domain\Collection;

use Domain\Collection\Middleware\CollectionMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->put(
        '/protected/collection/{command:create}[/]',
        CollectionMiddleware::class,
        'collection-create-community'
    );

    $app->delete(
        '/protected/collection/{collectionId}/{command:delete}[/]',
        CollectionMiddleware::class,
        'collection-delete'
    );

    $app->post(
        '/protected/collection/{collectionId}/{command:edit}[/]',
        CollectionMiddleware::class,
        'collection-edit'
    );

    $app->post(
        '/protected/collection/{collectionId}/{command:image-upload}/crop-start/{x1}/{y1}/crop-end/{x2}/{y2}[/]',
        CollectionMiddleware::class,
        'collection-image-upload'
    );

    $app->delete(
        '/protected/collection/{collectionId}/{command:image-delete}[/]',
        CollectionMiddleware::class,
        'collection-image-delete'
    );

    $app->post(
        '/protected/collection/{collectionId}/{command:set-public-options}[/]',
        CollectionMiddleware::class,
        'collection-set-public-options'
    );
};