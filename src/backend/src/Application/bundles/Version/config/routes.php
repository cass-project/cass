<?php
namespace CASS\Application\Version;

use CASS\Application\Version\Middleware\VersionMiddleware;
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