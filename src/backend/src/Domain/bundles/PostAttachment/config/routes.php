<?php
namespace Domain\PostAttachment;

use Domain\PostAttachment\Middleware\PostAttachmentMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {
    $app->post(
        '/protected/post-attachment/{command:upload}[/]',
        PostAttachmentMiddleware::class,
        'post-attachment-upload-what'
    );
};