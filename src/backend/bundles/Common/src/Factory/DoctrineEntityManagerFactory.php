<?php
namespace Common\Factory;

use Common\Bootstrap\Bundle\BundleService;
use Common\Service\SharedConfigService;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

class DoctrineEntityManagerFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): EntityManager
    {
        $bundleService =  $container->get(BundleService::class); /** @var BundleService $bundleService */
        $entitySourceDirs = [];

        foreach($bundleService->getBundles() as $bundle ){
            $bundleEntityDir = $bundle->getDir()."/Entity";

            if(is_dir($bundleEntityDir)){
                $entitySourceDirs[] = $bundleEntityDir;
            }
        }

        $sharedConfigService = $container->get(SharedConfigService::class); /** @var SharedConfigService $sharedConfigService */
        $config = $sharedConfigService->get('doctrine2');

        $doctrineConfig = Setup::createAnnotationMetadataConfiguration($entitySourceDirs, true);

        return EntityManager::create($config['connection_options'], $doctrineConfig);
    }
}