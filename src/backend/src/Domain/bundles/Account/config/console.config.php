<?php
namespace CASS\Domain\EmailVerification;

use CASS\Domain\Account\Command\DeleteAccountCommand;
use CASS\Domain\Account\Command\ProcessAccountDeleteRequestsCommand;

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