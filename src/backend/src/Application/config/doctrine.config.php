<?php
namespace Application\Common;

return [
    'php-di' => [
        'config.doctrine2' => [
            'connection_options'=> [
                'driver'   => 'pdo_mysql',
                'charset'  => 'utf8'
            ]
        ]
    ]
];