<?php
namespace CASS\Domain\Profile;

use CASS\Domain\Profile\Console\Command\ProfileCard;

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