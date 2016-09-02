<?php
namespace CASS\Domain\Attachment;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use CASS\Domain\Attachment\Entity\Attachment;
use CASS\Domain\Attachment\Repository\AttachmentRepository;
use CASS\Domain\Attachment\Service\AttachmentService;
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
        AttachmentRepository::class => factory(new DoctrineRepositoryFactory(Attachment::class)),
        AttachmentService::class => object()
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
    ],
];