<?php
namespace Application\Console;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Console\Factory\ConsoleApplicationFactory;
use Symfony\Component\Console\Application;

return [
    'php-di' => [
        Application::class => factory(new ConsoleApplicationFactory())
    ]
];