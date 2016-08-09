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
        ],
        'config.version.current' => factory(function(Container $container) {
            return $container->get('composer.json')['version'];
        }),
        'config.storage.dir' => '/data/storage',
        'config.storage.www' => '/storage',
        'config.routes_group' => [
            'auth',
            'with-profile',
            'common',
            'final'
        ],
        ImageManager::class => factory(function(Container $container) {
            return new ImageManager([
                'driver' => 'gd'
            ]);
        }),
        EventEmitter::class => object(),
    ]
];