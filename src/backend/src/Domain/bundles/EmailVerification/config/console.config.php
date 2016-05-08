<?php
namespace Domain\EmailVerification;

use Domain\EmailVerification\Console\Command\AQMPSendMail;

return [
    'console' => [
        'commands' => [
            'AQMP' => [
                AQMPSendMail::class
            ]
        ]
    ]
];