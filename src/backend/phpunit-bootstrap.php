<?php
define('LB_BACKEND_DIRECTORY', __DIR__);
define('LB_BACKEND_ROUTE_PREFIX', '/backend/api');
define('LB_BACKEND_BUNDLES_DIR', __DIR__.'/bundles');
define('LB_FRONTEND_BASE_URL', '/public');
define('LB_FRONTEND_DIRECTORY', __DIR__.'/../frontend');

/** @var LBApplicationBootstrap $application */
$application = require __DIR__.'/application.php';
$application->bootstrap();