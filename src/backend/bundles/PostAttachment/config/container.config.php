<?php
use Auth\Service\CurrentAccountService;
use Common\Factory\DoctrineRepositoryFactory;
use PostAttachment\Entity\PostAttachment;
use PostAttachment\Middleware\PostAttachmentMiddleware;
use PostAttachment\Repository\PostAttachmentRepository;
use PostAttachment\Service\PostAttachmentService;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        'post-attachment-storage-dir' => 'post/attachment',
        PostAttachmentRepository::class => factory(new DoctrineRepositoryFactory(PostAttachment::class)),
        PostAttachmentService::class => object()->constructor(
            get('constants.storage'),
            get('post-attachment-storage-dir'),
            get(PostAttachmentRepository::class)
        ),
        PostAttachmentMiddleware::class => object()->constructor(
            get(CurrentAccountService::class),
            get(PostAttachmentService::class)
        ),
    ]
];