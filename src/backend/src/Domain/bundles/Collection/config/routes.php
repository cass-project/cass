<?php
namespace Domain\Collection;

use Domain\Collection\Middleware\CollectionMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->put(
        '/protected/{owner:community}/{communityId}/collection/{command:create}[/]',
        CollectionMiddleware::class,
        'collection-create-community'
    );

    $app->put(
        '/protected/{owner:profile}/current/collection/{command:create}[/]',
        CollectionMiddleware::class,
        'collection-create-profile'
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
        'profile-image-upload'
    );

};