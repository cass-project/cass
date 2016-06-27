<?php
namespace Application;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use Evenement\EventEmitter;
use Intervention\Image\ImageManager;

return [
    'php-di' => [
        'composer.json' => factory(function(Container $container) {
            return json_decode(file_get_contents(sprintf('%s/composer.json', $container->get('paths')['backend'])), true);
        }),
        'paths' => [
            'backend' => sprintf('%s/../../../', __DIR__),
            'frontend' => sprintf('%s/../../../../frontend', __DIR__),
            'www' => sprintf('%s/../../../../www/app', __DIR__),
            'wwwPrefix' => '/public',
            'assetsDir' => sprintf('%s/../../../../www/app/dist/assets', __DIR__),
        ],
        'config.version.current' => factory(function(Container $container) {
            return $container->get('composer.json')['version'];
        }),
        'config.storage' => sprintf('%s/../../../../www/app/dist/storage', __DIR__),
        'config.paths.assets.dir' => sprintf('%s/../../../../www/app/dist/assets', __DIR__),
        'config.paths.assets.www' => '/dist/assets',
        ImageManager::class => factory(function(Container $container) {
            return new ImageManager([
                'driver' => 'gd'
            ]);
        }),
        EventEmitter::class => object()
    ]
];