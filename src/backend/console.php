<?php
/** @see https://xtreamwayz.com/blog/2016-02-07-zend-expressive-console-cli-commands */
/** Example: php console profile:card 1 */

if(php_sapi_name() !== 'cli') {
    die('This script can be only executed in CLI');
}

/** @var \Zend\Expressive\Application $app */
$app = require __DIR__.'/bootstrap.php';

/** @var  Symfony\Component\Console\Application $consoleApp */
$consoleApp = $app->getContainer()->get(Symfony\Component\Console\Application::class);
$consoleApp->run();