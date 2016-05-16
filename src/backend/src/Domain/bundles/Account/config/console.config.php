<?php
namespace Domain\EmailVerification;

use Domain\Account\Command\DeleteAccountCommand;
use Domain\Account\Command\ProcessAccountDeleteRequestsCommand;

return [
    'php-di' => [
        'config.console' => [
            'commands' => [
                'Account' => [
                    DeleteAccountCommand::class,
                    ProcessAccountDeleteRequestsCommand::class
                ]
            ]
        ]
    ]
];