<?php
namespace ThemeEditor\Factory\Service;

use Interop\Container\ContainerInterface;
use ThemeEditor\Service\ThemeEditorService;
use Zend\ServiceManager\Factory\FactoryInterface;

class ThemeEditorServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ThemeEditorService();
    }
}