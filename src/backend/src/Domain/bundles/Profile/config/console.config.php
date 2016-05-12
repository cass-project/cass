<?php
namespace Domain\Profile;

use Domain\Profile\Console\Command\ProfileCard;

return [
    'php-di' => [
        'config.console' => [
            'commands' => [
                'profile' => [
                    ProfileCard::class
                ]
            ]
        ]
    ]
];