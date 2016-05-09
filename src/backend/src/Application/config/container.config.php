<?php
namespace Application;

return [
    'php-di' => [
        'route-prefix' => '/backend/api',
        'paths' => [
            'backend' => sprintf('%s/../../../', __DIR__),
            'frontend' => sprintf('%s/../../../../frontend', __DIR__),
            'www' => sprintf('%s/../../../../www', __DIR__),
            'storage' => sprintf('%s/../../../../www/app/public/storage', __DIR__),
        ]
    ]
];