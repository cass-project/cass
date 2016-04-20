<?php
use Profile\Console\Command\ProfileCard;

return [
    'console' => [
        'commands' => [
            'profile' => [
                ProfileCard::class
            ]
        ]
    ]
];