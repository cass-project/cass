<?php
namespace EmailVerification\Factory\Service;

use Auth\Service\CurrentAccountService;
use EmailVerification\Repository\EmailVerificationRepository;
use EmailVerification\Service\EmailVerificationService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class EmailVerificationServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): EmailVerificationService
    {
        $currentAccountService = $container->get(CurrentAccountService::class); /** @var CurrentAccountService $currentAccountService */
        $emailVerificationRepository = $container->get(EmailVerificationRepository::class); /** @var EmailVerificationRepository $emailVerificationRepository */

        return new EmailVerificationService($currentAccountService, $emailVerificationRepository);
    }
}