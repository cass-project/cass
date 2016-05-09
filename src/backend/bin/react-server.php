<?php
use React\EventLoop\Factory;
use React2Psr7\ReactRequestHandler;
use Zend\Expressive\Application;

$application = require_once(__DIR__ .'/../bootstrap/bootstrap.php');

$RESTApplication = \Zend\Expressive\AppFactory::create();
$RESTApplication->pipe('/backend/api', $application);

/** @var \Zend\ServiceManager\ServiceManager $zendContainer */
$zendContainer = $RESTApplication->getContainer();

$loop = Factory::create();
$socket = new React\Socket\Server($loop);
$http = new React\Http\Server($socket, $loop);

$http->on('request', new ReactRequestHandler($RESTApplication));

$socket->listen(1337);
$loop->run();