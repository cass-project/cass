<?php

use React\EventLoop\Factory;
use React2Psr7\ReactRequestHandler;
use Zend\Expressive\Application;

require_once(__DIR__ . '/../../backend/constants.php');
require_once(LB_BACKEND_DIRECTORY . '/vendor/autoload.php');

/** @var LBApplicationBootstrap $application */
$application = require(LB_BACKEND_DIRECTORY.'/application.php');
$application->bootstrap();
$application->createApplication();

$loop = Factory::create();
$socket = new React\Socket\Server($loop);
$http = new React\Http\Server($socket, $loop);

$http->on('request', new ReactRequestHandler($application->getContainer()->get(Application::class)));

$socket->listen(1337);
$loop->run();