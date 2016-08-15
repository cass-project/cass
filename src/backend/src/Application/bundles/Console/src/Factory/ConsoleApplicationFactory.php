<?php
namespace Application\Console\Factory;

use Application\DIFactoryInterface;
use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Application as ConsoleApplication;

class ConsoleApplicationFactory implements DIFactoryInterface
{
    public function __invoke(ContainerInterface $container) {
        $config = $container->get('config.console');
        $consoleApplication = new ConsoleApplication($config['title'] ?? 'Console', $config['version'] ?? '1.0');
        $this->addCommands($consoleApplication, $container, $config['commands']);

        return $consoleApplication;
    }

    private function addCommands(ConsoleApplication $application, ContainerInterface $appContainer, array $commands) {
        foreach($commands as $input) {
            if(is_array($input)) {
                $this->addCommands($application, $appContainer, $input);
            }else if(is_string($input)) {
                $application->add($appContainer->get($input));
            }else{
                throw new \Exception('Invalid console command');
            }
        }
    }
}