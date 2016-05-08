<?php
namespace Application\Profile;

use Application\Profile\Console\Command\ProfileCard;

return [
    'console' => [
        'commands' => [
            'profile' => [
                ProfileCard::class
            ]
        ]
    ]
];