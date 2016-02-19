<?php
namespace ThemeEditor\Factory\Service;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use ThemeEditor\Service\ThemeEditorService;
use Zend\ServiceManager\Factory\FactoryInterface;

class ThemeEditorServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);

        return new ThemeEditorService($entityManager);
    }
}