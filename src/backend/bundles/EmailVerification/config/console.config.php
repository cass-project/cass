<?php
use EmailVerification\Console\Command\AQMPReceive;
use EmailVerification\Console\Command\AQMPSend;

return [
    'console' => [
        'commands' => [
            'AQMP' => [
                AQMPSend::class,
                AQMPReceive::class
            ]
        ]
    ]
];