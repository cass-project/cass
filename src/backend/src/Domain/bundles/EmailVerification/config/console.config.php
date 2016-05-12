<?php
namespace Domain\EmailVerification;

use Domain\EmailVerification\Console\Command\AMQPSendMail;

return [
    'php-di' => [
        'config.console' => [
            'commands' => [
                'AMQP' => [
                    AMQPSendMail::class
                ]
            ]
        ]
    ]
];