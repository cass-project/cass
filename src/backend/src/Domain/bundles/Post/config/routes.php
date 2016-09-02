<?php
namespace CASS\Domain\Bundles\Post;

use CASS\Domain\Bundles\Post\Middleware\PostMiddleware;

return [
    'common' => [
        [
            'type'       => 'route',
            'method'     => 'put',
            'url'        => '/protected/post/{command:create}',
            'middleware' => PostMiddleware::class,
            'name'       => 'post-create'
        ],
        [
            'type'       => 'route',
            'method'     => 'delete',
            'url'        => '/protected/post/{postId}/{command:delete}',
            'middleware' => PostMiddleware::class,
            'name'       => 'post-delete'
        ],
        [
            'type'       => 'route',
            'method'     => 'post',
            'url'        => '/protected/post/{postId}/{command:edit}',
            'middleware' => PostMiddleware::class,
            'name'       => 'post-edit'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/post/{postId}/{command:get}',
            'middleware' => PostMiddleware::class,
            'name'       => 'post-get'
        ],
    ]
];