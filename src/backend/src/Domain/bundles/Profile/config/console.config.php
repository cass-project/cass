<?php
namespace Domain\Profile;

use Domain\Profile\Console\Command\ProfileCard;

return [
    'console' => [
        'commands' => [
            'profile' => [
                ProfileCard::class
            ]
        ]
    ]
];