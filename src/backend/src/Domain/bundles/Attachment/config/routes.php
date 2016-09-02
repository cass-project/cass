<?php
namespace CASS\Domain\Attachment;

use CASS\Domain\Attachment\Middleware\AttachmentMiddleware;

return [
    'common' => [
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/attachment/{command:upload}[/]',
            'middleware' => AttachmentMiddleware::class,
            'name' => 'attachment-upload',
        ],
        [
            'type' => 'route',
            'method' => 'put',
            'url' => '/protected/attachment/{command:link}[/]',
            'middleware' => AttachmentMiddleware::class,
            'name' => 'attachment-link',
        ],
    ],
];