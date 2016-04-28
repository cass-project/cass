<?php
use EmailVerification\Console\Command\AQMPSendMail;

return [
    'console' => [
        'commands' => [
            'AQMP' => [
                AQMPSendMail::class
            ]
        ]
    ]
];