<?php
use Application\PostAttachment\Middleware\PostAttachmentMiddleware;
use Zend\Expressive\Application;

return function (Application $app, string $prefix) {
    $app->post(
        sprintf('%s/protected/post-attachment/{command:upload}[/]', $prefix),
        PostAttachmentMiddleware::class,
        'post-attachment-upload'
    );
};