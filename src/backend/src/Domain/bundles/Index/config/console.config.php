<?php
namespace Domain\Fake;

use Domain\Index\Scripts\UpdateIndexScript\UpdateIndexScript;

return [
    'php-di' => [
        'config.console' => [
            'commands' => [
                'index' => [
                    UpdateIndexScript::class
                ],
            ],
        ],
    ],
];