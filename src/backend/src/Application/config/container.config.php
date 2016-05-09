<?php
namespace Application;

return [
    'php-di' => [
        'paths' => [
            'backend' => sprintf('%s/../../../', __DIR__),
            'frontend' => sprintf('%s/../../../../frontend', __DIR__),
            'www' => sprintf('%s/../../../../www', __DIR__),
            'storage' => sprintf('%s/../../../../www/app/public/storage', __DIR__),
        ],
        'env' => \DI\factory(function() {
            $validEnv = ['development', 'production', 'test'];
            $env = getenv('APPLICATION_ENV');

            if($env === false) {
                $env = 'development';
            }

            if(! in_array($env, $validEnv)) {
                throw new \Exception(sprintf('Invalid env, got `%s`, should be: %s', $env, join(', ', $validEnv)));
            }

            return $env;
        })
    ]
];