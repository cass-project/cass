<?php
namespace DataBundle\src\Factory;

use Application\Bootstrap\Bundle\BundleService;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DoctrineEntityManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // Create a simple "default" Doctrine ORM configuration for Annotations
        /** @var BundleService $bundleService */
        $bundleService =  $container->get(BundleService::class);
        $entitySourceDirs = [];
        foreach($bundleService->getBundles() as $bundle ){
            $bundleEntityDir = $bundle->getDir()."/Entity";
            if(is_dir($bundleEntityDir)){
                $entitySourceDirs[] = $bundleEntityDir;
            }
        }

        $config = $container->get('DoctrineConfig');

        $doctrineConfig = Setup::createAnnotationMetadataConfiguration($entitySourceDirs, $config['isDevMode']);

        return EntityManager::create($config['connection_options'], $doctrineConfig);
    }

}