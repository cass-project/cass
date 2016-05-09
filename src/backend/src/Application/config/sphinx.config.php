<?php
namespace Application;

return [
    'php-di' => [
        'config.sphinx' => [
            'connection_options'=> [
                'server' => 'unix:///tmp/sphinx.socket',
            ]
        ]
    ]
];