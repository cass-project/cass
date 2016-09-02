<?php
namespace CASS\Domain\Bundles\Profile;

use CASS\Domain\Bundles\Profile\Console\Command\ProfileCard;

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