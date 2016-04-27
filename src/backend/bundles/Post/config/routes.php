<?php
use Post\Middleware\PostMiddleware;
use Zend\Expressive\Application;

return function (Application $app, string $prefix) {
    $app->put(
        sprintf("%s/protected/post/{command:create}", $prefix),
        PostMiddleware::class,
        'post-create'
    );

    $app->delete(
        sprintf("%s/protected/post/{postId}/{command:delete}", $prefix),
        PostMiddleware::class,
        'post-delete'
    );

    $app->post(
        sprintf("%s/protected/post/{postId}/{command:edit}", $prefix),
        PostMiddleware::class,
        'post-edit'
    );

    $app->get(
        sprintf("%s/protected/post/{postId}/{command:get}", $prefix),
        PostMiddleware::class,
        'post-get'
    );
};