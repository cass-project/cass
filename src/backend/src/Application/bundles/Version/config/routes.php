<?php
namespace Application\Version;

use Application\Version\Middleware\VersionMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {
    $app->get('/version[/]', VersionMiddleware::class, 'get-version');
};