<?php
namespace CASS\Domain\Bundles\Theme;

use DI\Container;
use function DI\object;
use function DI\factory;
use function DI\get;

use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use CASS\Domain\Bundles\Theme\Frontline\ThemeScript;
use CASS\Domain\Bundles\Theme\Repository\ThemeRepository;
use CASS\Domain\Bundles\Theme\Service\ThemeService;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

return [
    'php-di' => [
        'config.paths.theme.preview.www' => factory(function(Container $container) {
            return sprintf('%s/entity/themes/preview', $container->get('config.storage.www'));
        }),
        'config.paths.theme.preview.dir' => factory(function(Container $container) {
            return sprintf('%s/entity/themes/preview/', $container->get('config.storage.dir'));
        }),
        ThemeScript::class => object()->constructorParameter('wwwStorage', factory(function(Container $container) {
            return $container->get('config.paths.theme.preview.www');
        })),
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