<?php
namespace CASS\Application\Bundles\Stage;

use CASS\Application\Bundles\Stage\Command\StageDemoCommand;
use CASS\Application\Bundles\Stage\Command\StageDemoSyncCommand;
use CASS\Application\Bundles\Stage\Command\StageThemesCommand;

return [
    'php-di' => [
        'config.console' => [
            'commands' => [
                'Stage' => [
                    StageDemoCommand::class,
                    StageThemesCommand::class,
                    StageDemoSyncCommand::class,
                ]
            ]
        ]
    ]
];