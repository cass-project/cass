<?php
namespace CASS\Domain\EmailVerification;

use CASS\Domain\EmailVerification\Console\Command\AMQPSendMail;

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