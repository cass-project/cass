<?php
namespace CASS\Domain\Bundles\Collection;

use CASS\Domain\Bundles\Collection\Middleware\CollectionMiddleware;

return [
    'common' => [
        [
            'type' => 'route',
            'method' => 'get',
            'url' => '/collection/{command:by-id}/{collectionId}[/]',
            'middleware' => CollectionMiddleware::class,
            'name' => 'collection-get-by-id',
        ],
        [
            'type' => 'route',
            'method' => 'get',
            'url' => '/collection/{command:by-sid}/{collectionSID}[/]',
            'middleware' => CollectionMiddleware::class,
            'name' => 'collection-get-by-sid',
        ],
        [
            'type' => 'route',
            'method' => 'put',
            'url' => '/protected/collection/{command:create}[/]',
            'middleware' => CollectionMiddleware::class,
            'name' => 'collection-create-community',
        ],
        [
            'type' => 'route',
            'method' => 'delete',
            'url' => '/protected/collection/{collectionId}/{command:delete}[/]',
            'middleware' => CollectionMiddleware::class,
            'name' => 'collection-delete',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/collection/{collectionId}/{command:edit}[/]',
            'middleware' => CollectionMiddleware::class,
            'name' => 'collection-edit',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/collection/{collectionId}/{command:image-upload}/crop-start/{x1}/{y1}/crop-end/{x2}/{y2}[/]',
            'middleware' => CollectionMiddleware::class,
            'name' => 'collection-image-upload',
        ],
        [
            'type' => 'route',
            'method' => 'delete',
            'url' => '/protected/collection/{collectionId}/{command:image-delete}[/]',
            'middleware' => CollectionMiddleware::class,
            'name' => 'collection-image-delete',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/collection/{collectionId}/{command:set-public-options}[/]',
            'middleware' => CollectionMiddleware::class,
            'name' => 'collection-set-public-options',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/collection/{collectionId}/{command:backdrop-upload}/textColor/{textColor}[/]',
            'middleware' => CollectionMiddleware::class,
            'name' => 'collection-backdrop-upload',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/collection/{collectionId}/{command:backdrop-none}[/]',
            'middleware' => CollectionMiddleware::class,
            'name' => 'collection-backdrop-none',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/collection/{collectionId}/{command:backdrop-preset}/presetId/{presetId}[/]',
            'middleware' => CollectionMiddleware::class,
            'name' => 'collection-backdrop-preset',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/collection/{collectionId}/{command:backdrop-color}/code/{code}[/]',
            'middleware' => CollectionMiddleware::class,
            'name' => 'collection-backdrop-color',
        ],
    ],
];