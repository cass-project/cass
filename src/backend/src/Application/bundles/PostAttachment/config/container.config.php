<?php
namespace Application\PostAttachment;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Auth\Service\CurrentAccountService;
use Application\Common\Factory\DoctrineRepositoryFactory;
use Application\PostAttachment\Entity\PostAttachment;
use Application\PostAttachment\Middleware\PostAttachmentMiddleware;
use Application\PostAttachment\Repository\PostAttachmentRepository;
use Application\PostAttachment\Service\PostAttachmentService;

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