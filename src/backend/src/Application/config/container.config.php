<?php
namespace Application;

return [
    'php-di' => [
        'paths' => [
            'backend' => sprintf('%s/../../../', __DIR__),
            'frontend' => sprintf('%s/../../../../frontend', __DIR__),
            'www' => sprintf('%s/../../../../www', __DIR__),
        ],
        'config.storage' => sprintf('%s/../../../../www/app/public/storage', __DIR__),
    ]
];