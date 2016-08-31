<?php
namespace CASS\Application\Bundles\Version;

use CASS\Application\Bundles\Version\Middleware\VersionMiddleware;
use Zend\Expressive\Application;

return [
    'common' => [
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/version[/]',
            'middleware' => VersionMiddleware::class,
            'name'       => 'get-version'
        ],
    ]
];