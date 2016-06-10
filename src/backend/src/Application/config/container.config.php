<?php
namespace Application;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        'paths' => [
            'backend' => sprintf('%s/../../../', __DIR__),
            'frontend' => sprintf('%s/../../../../frontend', __DIR__),
            'www' => sprintf('%s/../../../../www/app', __DIR__),
            'wwwPrefix' => '/public',
            'assetsDir' => sprintf('%s/../../../../www/app/dist/assets', __DIR__),
        ],
        'config.storage' => sprintf('%s/../../../../www/app/public/storage', __DIR__),
        'config.paths.assets.dir' => sprintf('%s/../../../../www/app/dist/assets', __DIR__),
        'config.paths.assets.www' => '/dist/assets',
    ]
];