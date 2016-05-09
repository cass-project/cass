<?php
namespace Domain\Post;

use Domain\Post\Middleware\PostMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {
    $app->put(
        "%s/protected/post/{command:create}",
        PostMiddleware::class,
        'post-create'
    );

    $app->delete(
        "%s/protected/post/{postId}/{command:delete}",
        PostMiddleware::class,
        'post-delete'
    );

    $app->post(
        "%s/protected/post/{postId}/{command:edit}",
        PostMiddleware::class,
        'post-edit'
    );

    $app->get(
        "%s/protected/post/{postId}/{command:get}",
        PostMiddleware::class,
        'post-get'
    );
};