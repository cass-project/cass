<?php
namespace CASS\Application\Frontline;

use CASS\Application\Frontline\Middleware\FrontlineMiddleware;
use Zend\Expressive\Application;

return [
    'common' => [
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/frontline/{tags}[/]',
            'middleware' => FrontlineMiddleware::class,
            'name'       => 'frontline'
        ],
    ]
];