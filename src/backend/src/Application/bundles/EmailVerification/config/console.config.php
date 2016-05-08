<?php
namespace Application\EmailVerification;

use Application\EmailVerification\Console\Command\AQMPSendMail;

return [
    'console' => [
        'commands' => [
            'AQMP' => [
                AQMPSendMail::class
            ]
        ]
    ]
];