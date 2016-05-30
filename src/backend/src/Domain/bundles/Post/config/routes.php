<?php
namespace Domain\Post;

use Domain\Post\Middleware\PostMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {
    $app->put(
        "/protected/post/{command:create}",
        PostMiddleware::class,
        'post-create'
    );

    $app->delete(
        "/protected/post/{postId}/{command:delete}",
        PostMiddleware::class,
        'post-delete'
    );

    $app->post(
        "/protected/post/{postId}/{command:edit}",
        PostMiddleware::class,
        'post-edit'
    );

    $app->get(
        "/protected/post/{postId}/{command:get}",
        PostMiddleware::class,
        'post-get'
    );
};