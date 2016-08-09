<?php
namespace Domain\PostAttachment;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\PostAttachment\Console\Command\PostAttachmentCleanup;
use Domain\PostAttachment\Entity\PostAttachment;
use Domain\PostAttachment\Repository\PostAttachmentRepository;
use Domain\PostAttachment\Service\PostAttachmentService;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

return [
    'php-di' => [
        'config.paths.attachment.dir' => factory(function(Container $container) {
            return sprintf('%s/entity/attachment', $container->get('config.storage.dir'));
        }),
        'config.paths.attachment.www' => factory(function(Container $container) {
            return sprintf('%s/entity/attachment', $container->get('config.storage.www'));
        }),
        PostAttachmentRepository::class => factory(new DoctrineRepositoryFactory(PostAttachment::class)),
        PostAttachmentService::class => object()
            ->constructorParameter('wwwDir', factory(function(Container $container) {
                return $container->get('config.paths.attachment.www');
            }))
            ->constructorParameter('fileSystem', factory(function(Container $container) {
                $env = $container->get('config.env');

                if($env === 'test') {
                    return new Filesystem(new MemoryAdapter());
                }else{
                    return new Filesystem(new Local($container->get('config.paths.attachment.dir')));
                }
            })),
        PostAttachmentCleanup::class => object()->constructorParameter('config', factory(function(Container $container){
            return $container->get('config.post-attachment');
        }))
    ],
];