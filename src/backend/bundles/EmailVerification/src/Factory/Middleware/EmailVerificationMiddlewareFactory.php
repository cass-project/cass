<?php
namespace EmailVerification\Factory\Middleware;

use EmailVerification\Middleware\EmailVerificationMiddleware;
use EmailVerification\Service\EmailVerificationService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class EmailVerificationMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): EmailVerificationMiddleware
    {
        $emailVerificationService = $container->get(EmailVerificationService::class); /** @var EmailVerificationService $emailVerificationService */

        return new EmailVerificationMiddleware($emailVerificationService);
    }
}