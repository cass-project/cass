<?php
namespace Domain\PostAttachment;


use Domain\PostAttachment\Console\Command\PostAttachmentCleanup;

return [
    'php-di' => [
        'config.console' => [
            'commands' => [
                'post-attachment' => [
                    PostAttachmentCleanup::class
                ]
            ]
        ],
        'config.post-attachment' => [
            'cleanup_options'=> [
                'timeInterval' => "1 week"
            ]
        ]
    ]
];