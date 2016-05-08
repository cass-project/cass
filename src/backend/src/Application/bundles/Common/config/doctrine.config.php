<?php
namespace Application\Common;

return [
    'doctrine2' => [
        'connection_options'=> [
            'driver'   => 'pdo_mysql',
            'host'     => '127.0.0.1',
            'dbname'   => 'cass_development',
            'user'     => 'root',
            'password' => '1234',
            'charset'  => 'utf8'
        ]
    ]
];