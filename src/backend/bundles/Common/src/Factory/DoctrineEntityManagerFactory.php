<?php
namespace Common\Factory;

use Common\Bootstrap\Bundle\BundleService;
use Common\Service\SharedConfigService;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Logging\DebugStack;
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

        /** @var SharedConfigService $sharedConfigService */
        $sharedConfigService = $container->get(SharedConfigService::class);
        $config = $sharedConfigService->get('doctrine2');

        $doctrineConfig = Setup::createAnnotationMetadataConfiguration($entitySourceDirs, $config['isDevMode']);
        if($config['isDevMode']) {
            $doctrineConfig->setSQLLogger(new DebugStack());
        }
        return EntityManager::create($config['connection_options'], $doctrineConfig);
    }
}