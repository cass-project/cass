<?php
require_once(__DIR__ . '/../../backend/constants.php');

/** @var LBApplicationBootstrap $application */
$application = require(LB_BACKEND_DIRECTORY . '/application.php');
$application->bootstrap();
$application->createApplication();
$application->run();
