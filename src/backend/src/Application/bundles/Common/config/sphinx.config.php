<?php
namespace Application\Common;

return [
    'php-di' => [
        'sphinx' => [
            'connection_options'=> [
                'server' => 'unix:///tmp/sphinx.socket',
            ]
        ]
    ]
];