<?php
namespace CASS\Project\Bundles\Stage;

use function DI\object;
use function DI\factory;
use function DI\get;

use CASS\Project\Bundles\Stage\Command\StageDemoCommand;
use CASS\Project\Bundles\Stage\Command\StageThemesCommand;

return [
    'php-di' => [
        'config.console' => [
            'commands' => [
                'stage' => [
                    StageDemoCommand::class,
                    StageThemesCommand::class,
                ]
            ]
        ]
    ]
];