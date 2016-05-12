<?php
namespace Domain\PostAttachment;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Auth\Service\CurrentAccountService;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\PostAttachment\Console\Command\PostAttachmentCleanup;
use Domain\PostAttachment\Entity\PostAttachment;
use Domain\PostAttachment\Middleware\PostAttachmentMiddleware;
use Domain\PostAttachment\Repository\PostAttachmentRepository;
use Domain\PostAttachment\Service\PostAttachmentService;

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
        PostAttachmentCleanup::class => object()->constructor(
            get('config.post-attachment'),
            get(PostAttachmentRepository::class)
        )
    ]
];