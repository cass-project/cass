<?php
use React\EventLoop\Factory;
use React2Psr7\ReactRequestHandler;
use Zend\Expressive\Application;

require_once(__DIR__ .'/../bootstrap/bootstrap.php');

$loop = Factory::create();
$socket = new React\Socket\Server($loop);
$http = new React\Http\Server($socket, $loop);

$http->on('request', new ReactRequestHandler($application->getContainer()->get(Application::class)));

$socket->listen(1337);
$loop->run();