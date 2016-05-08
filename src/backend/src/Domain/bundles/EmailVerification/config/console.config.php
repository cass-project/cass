<?php
namespace Domain\EmailVerification;

use Domain\EmailVerification\Console\Command\AMQPSendMail;

return [
    'console' => [
        'commands' => [
            'AMQP' => [
                AMQPSendMail::class
            ]
        ]
    ]
];