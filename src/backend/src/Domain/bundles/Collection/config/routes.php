<?php
namespace CASS\Domain\Collection;

use CASS\Domain\Collection\Middleware\CollectionMiddleware;
return [
    'common' => [
        [
            'type'       => 'route',
            'method'     => 'put',
            'url'        => '/protected/collection/{command:create}[/]',
            'middleware' => CollectionMiddleware::class,
            'name'       => 'collection-create-community'
        ],
        [
            'type'       => 'route',
            'method'     => 'delete',
            'url'        => '/protected/collection/{collectionId}/{command:delete}[/]',
            'middleware' => CollectionMiddleware::class,
            'name'       => 'collection-delete'
        ],
        [
            'type'       => 'route',
            'method'     => 'post',
            'url'        => '/protected/collection/{collectionId}/{command:edit}[/]',
            'middleware' => CollectionMiddleware::class,
            'name'       => 'collection-edit'
        ],
        [
            'type'       => 'route',
            'method'     => 'post',
            'url'        => '/protected/collection/{collectionId}/{command:image-upload}/crop-start/{x1}/{y1}/crop-end/{x2}/{y2}[/]',
            'middleware' => CollectionMiddleware::class,
            'name'       => 'collection-image-upload'
        ],
        [
            'type'       => 'route',
            'method'     => 'delete',
            'url'        => '/protected/collection/{collectionId}/{command:image-delete}[/]',
            'middleware' => CollectionMiddleware::class,
            'name'       => 'collection-image-delete'
        ],
        [
            'type'       => 'route',
            'method'     => 'post',
            'url'        => '/protected/collection/{collectionId}/{command:set-public-options}[/]',
            'middleware' => CollectionMiddleware::class,
            'name'       => 'collection-set-public-options'
        ],
    ]
];