<?php
namespace EmailVerification;

use EmailVerification\Middleware\EmailVerificationMiddleware;
use Zend\Expressive\Application;

return function (Application $app, string $prefix)
{
    $app->get(
        sprintf('%s/protected/email-verification/{command:request}/{newEmail}[/]', $prefix),
        EmailVerificationMiddleware::class,
        'email-verification-request'
    );

    $app->get(
        sprintf('%s/email-verification/{command: confirm}/{token}[/]', $prefix),
        EmailVerificationMiddleware::class,
        'email-verification-confirm'
    );
};