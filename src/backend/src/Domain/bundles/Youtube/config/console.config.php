<?php
namespace Domain\Fake;


use DI\Container;
use Domain\Youtube\Console\Command\YoutubeGetMetadata;
use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        'config.console' => [
            'commands' => [
                'youtube' => [
                    YoutubeGetMetadata::class,
                ],
            ],
        ],
    ],
];