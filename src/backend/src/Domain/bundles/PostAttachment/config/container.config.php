<?php
namespace Domain\PostAttachment;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\PostAttachment\Entity\PostAttachment;
use Domain\PostAttachment\Repository\PostAttachmentRepository;
use Domain\PostAttachment\Service\PostAttachmentService;

return [
    'php-di' => [
        'post-attachment-storage-dir' => 'post/attachment',
        PostAttachmentRepository::class => factory(new DoctrineRepositoryFactory(PostAttachment::class)),
        PostAttachmentService::class => object()
            ->constructorParameter('storageDir', get('config.storage'))
            ->constructorParameter('uploadDir', get('post-attachment-storage-dir')),
    ]
];