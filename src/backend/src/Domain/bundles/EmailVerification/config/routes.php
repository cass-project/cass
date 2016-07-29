<?php
namespace Domain\EmailVerification;

use Domain\EmailVerification\Middleware\EmailVerificationMiddleware;

return [
    'common' => [
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/email-verification/{command:request}/{newEmail}[/]',
            'middleware' => EmailVerificationMiddleware::class,
            'name'       => 'email-verification-request'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/email-verification/{command: confirm}/{token}[/]',
            'middleware' => EmailVerificationMiddleware::class,
            'name'       => 'email-verification-confirm'
        ],
    ]
];