<?php
namespace ThemeEditor\Factory\Service;

use Data\Repository\ThemeRepository;
use Interop\Container\ContainerInterface;
use ThemeEditor\Service\ThemeEditorService;
use Zend\ServiceManager\Factory\FactoryInterface;

class ThemeEditorServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $themeRepository = $container->get(ThemeRepository::class); /** @var ThemeRepository $themeRepository */

        return new ThemeEditorService($themeRepository);
    }
}