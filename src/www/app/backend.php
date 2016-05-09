<?php
/** @var \Zend\Expressive\Application $application */
$application = require __DIR__ . '/../../backend/bootstrap/bootstrap.php';

$RESTApiApplication = \Zend\Expressive\AppFactory::create();
$RESTApiApplication->pipe('/backend/api', $application);
$RESTApiApplication->pipeRoutingMiddleware();
$RESTApiApplication->pipeDispatchMiddleware();

$RESTApiApplication->run();