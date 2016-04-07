<?php
namespace Development\Factory\Middleware;

use Development\Middleware\DumpConfigMiddleware;
use Development\Service\DumpConfigService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DumpConfigMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $isEnabled = $container->has('development') ? $container->get('development') : false;
        $dumpConfigService = $container->get(DumpConfigService::class); /** @var DumpConfigService $dumpConfigService */

        return new DumpConfigMiddleware($isEnabled, $dumpConfigService);
    }
}