<?php
/** @var \Zend\Expressive\Application $application */
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Expressive\Emitter\EmitterStack;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\ServiceManager\ServiceManager;

$application = require __DIR__ . '/../../backend/bootstrap/bootstrap.php';

$container = $container ?: new ServiceManager();
$router    = $router    ?: new FastRouteRouter();
$emitter   = new EmitterStack();
$emitter->push(new SapiEmitter());

$RESTApiApplication = new \Zend\Expressive\Application($router, $container, new \Application\Bootstrap\FinalHandler(), $emitter);
$RESTApiApplication->pipe('/backend/api', $application);
$RESTApiApplication->pipeRoutingMiddleware();
$RESTApiApplication->pipeDispatchMiddleware();

$RESTApiApplication->run();