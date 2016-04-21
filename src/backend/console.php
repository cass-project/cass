<?php
/** @see https://xtreamwayz.com/blog/2016-02-07-zend-expressive-console-cli-commands */
/** Example: php console profile:card 1 */

use Common\Bootstrap\Bundle\BundleService;
use Common\CommonBundle;
use Common\Service\SharedConfigService;
use Symfony\Component\Console\Application as ConsoleApplication;

if(php_sapi_name() !== 'cli') {
    die('This script can be only executed in CLI');
}

require_once(__DIR__.'/constants.php');

/** @var LBApplicationBootstrap $application */
$application = require LB_BACKEND_DIRECTORY.'/application.php';
$application->bootstrap();

$appContainer = $application->getContainer();
$appConfig = $application->getAppConfig();

$consoleApplication = new ConsoleApplication('CASS Console', 'dev');
$consoleCommands = $appConfig->get('console')['commands'];

function addCommands(ConsoleApplication $application, \Interop\Container\ContainerInterface $appContainer, array $commands) {
    foreach($commands as $input) {
        if(is_array($input)) {
            addCommands($application, $appContainer, $input);
        }else if(is_string($input)) {
            $application->add($appContainer->get($input));
        }else{
            throw new \Exception('Invalid console command');
        }
    }
}

addCommands($consoleApplication, $appContainer, $consoleCommands);

$consoleApplication->run();