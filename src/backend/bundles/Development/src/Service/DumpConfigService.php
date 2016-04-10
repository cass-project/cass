<?php
namespace Development\Service;

use Common\Service\SharedConfigService;
use Interop\Container\ContainerInterface;

class DumpConfigService
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getOverallConfiguration() {
        $container = $this->container;
        $sharedConfigService = $container->get(SharedConfigService::class); /** @var SharedConfigService $sharedConfigService */

        return $sharedConfigService->all();
    }

    public function getApplicationConfiguration() {
        $container = $this->container;

        return $container->get('DevelopmentApplicationConfig');
    }

    public function getProvideConfiguration() {
        $container = $this->container;

        return $container->get('DevelopmentProvideConfig');
    }

    public function getContainerConfiguration() {
        $container = $this->container;
        $sharedConfigService = $container->get(SharedConfigService::class); /** @var SharedConfigService $sharedConfigService */

        return $sharedConfigService->get('zend_service_manager');
    }
}