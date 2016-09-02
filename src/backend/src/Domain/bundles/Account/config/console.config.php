<?php
namespace CASS\Domain\Bundles\EmailVerification;

use CASS\Domain\Bundles\Account\Command\DeleteAccountCommand;
use CASS\Domain\Bundles\Account\Command\ProcessAccountDeleteRequestsCommand;

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