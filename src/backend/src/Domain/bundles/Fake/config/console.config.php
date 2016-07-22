<?php
namespace Domain\Fake;

use Domain\Fake\Console\Command\FakeUp;

return [
    'php-di' => [
        'config.console' => [
            'commands' => [
                'fake' => [
                    FakeUp::class,
                ],
            ],
        ],
    ],
];