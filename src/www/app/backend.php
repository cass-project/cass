<?php
/** @var \Zend\Expressive\Application $application */
$application = require __DIR__.'/../../backend/bootstrap.php';

$RESTApiApplication = \Zend\Expressive\AppFactory::create();
$RESTApiApplication->pipe('/backend/api', $application);

$RESTApiApplication->run();