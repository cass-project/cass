<?php
define('LB_BACKEND_DIRECTORY', __DIR__.'/../../backend');
define('LB_BACKEND_ROUTE_PREFIX', '/backend/api');
define('LB_BACKEND_BUNDLES_DIR', __DIR__.'/../../backend/bundles');
define('LB_FRONTEND_BASE_URL', '/public');
define('LB_FRONTEND_DIRECTORY', __DIR__.'/../../frontend');

/** @var LBApplicationBootstrap $application */
$application = require LB_BACKEND_DIRECTORY.'/application.php';
$application->bootstrap();
$application->run();
