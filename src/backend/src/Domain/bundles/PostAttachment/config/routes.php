<?php
namespace Domain\PostAttachment;

use Domain\PostAttachment\Middleware\PostAttachmentMiddleware;

return [
    'common' => [
        [
            'type'       => 'route',
            'method'     => 'post',
            'url'        => '/protected/post-attachment/{command:upload}[/]',
            'middleware' => PostAttachmentMiddleware::class,
            'name'       => 'post-attachment-upload'
        ],
        [
            'type'       => 'route',
            'method'     => 'put',
            'url'        => '/protected/post-attachment/{command:link}[/]',
            'middleware' => PostAttachmentMiddleware::class,
            'name'       => 'post-attachment-link'
        ],
    ]
];