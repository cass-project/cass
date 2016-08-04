<?php
namespace Domain\Youtube;

use DI\Container;
use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Youtube\Console\Command\YoutubeGetMetadata;

return [
    'php-di' => [
        YoutubeGetMetadata::class => object()->constructorParameter('configOauth2Google',factory(function(Container $container){
            return $container->get('config.oauth2.google');
        })),
    ]
];