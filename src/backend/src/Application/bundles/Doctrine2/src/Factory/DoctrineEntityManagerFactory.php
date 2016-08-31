<?php
namespace CASS\Application\Bundles\Doctrine2\Factory;

use CASS\Application\Service\BundleService;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

class DoctrineEntityManagerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $bundleService =  $container->get(BundleService::class); /** @var \CASS\Application\Service\BundleService $bundleService */
        $entitySourceDirs = [];

        foreach($bundleService->getBundles() as $bundle ){
            $bundleEntityDir = $bundle->getDir()."/Entity";

            if(is_dir($bundleEntityDir)){
                $entitySourceDirs[] = $bundleEntityDir;
            }
        }

        $env = $container->get('config.env');
        $config = $container->get('config.doctrine2')["env.{$env}"];
        $doctrineConfig = Setup::createAnnotationMetadataConfiguration($entitySourceDirs, true);

        return EntityManager::create($config['connection_options'], $doctrineConfig);
    }
}