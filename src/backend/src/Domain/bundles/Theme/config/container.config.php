<?php
namespace Domain\Theme;

use DI\Container;
use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Repository\ThemeRepository;
use Domain\Theme\Service\ThemeService;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

return [
    'php-di' => [
        'config.paths.theme.preview.dir' => factory(function(Container $container) {
            return sprintf('%s/entity/themes/preview/', $container->get('config.storage.dir'));
        }),
        ThemeRepository::class => factory(new DoctrineRepositoryFactory(Theme::class)),
        ThemeService::class => object()->constructorParameter('fileSystem', factory(function(Container $container) {
            $env = $container->get('config.env');
            $path = $container->get('config.paths.theme.preview.dir');

            if($env === 'test') {
                return new Filesystem(new MemoryAdapter($path));
            }else{
                return new Filesystem(new Local($path));
            }
        }))
    ]
];