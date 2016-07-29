<?php
namespace Application\Frontline;

use Application\Frontline\Middleware\FrontlineMiddleware;
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