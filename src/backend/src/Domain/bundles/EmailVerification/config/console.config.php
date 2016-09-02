<?php
namespace CASS\Domain\Bundles\EmailVerification;

use CASS\Domain\Bundles\EmailVerification\Console\Command\AMQPSendMail;

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