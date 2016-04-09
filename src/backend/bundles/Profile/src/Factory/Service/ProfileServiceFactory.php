<?php
namespace Profile\Factory\Service;

use Interop\Container\ContainerInterface;
use Profile\Repository\ProfileRepository;
use Profile\Service\ProfileService;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProfileServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $profileRepository = $container->get(ProfileRepository::class); /** @var ProfileRepository $profileRepository */

        return new ProfileService($profileRepository);
    }
}