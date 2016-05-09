<?php
namespace Domain\EmailVerification;

use Domain\EmailVerification\Middleware\EmailVerificationMiddleware;
use Zend\Expressive\Application;

return function (Application $app)
{
    $app->get(
        '/protected/email-verification/{command:request}/{newEmail}[/]',
        EmailVerificationMiddleware::class,
        'email-verification-request'
    );

    $app->get(
        '/email-verification/{command: confirm}/{token}[/]',
        EmailVerificationMiddleware::class,
        'email-verification-confirm'
    );
};