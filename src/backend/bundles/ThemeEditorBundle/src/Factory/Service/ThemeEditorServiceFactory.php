<?php
namespace ThemeEditor\Factory\Service;

use Data\Repository\ThemeRepository;
use Host\Service\CurrentHostService;
use Interop\Container\ContainerInterface;
use ThemeEditor\Service\ThemeEditorService;
use Zend\ServiceManager\Factory\FactoryInterface;

class ThemeEditorServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): ThemeEditorService
    {
        $themeRepository = $container->get(ThemeRepository::class); /** @var ThemeRepository $themeRepository */
        $currentHostService = $container->get(CurrentHostService::class); /** @var CurrentHostService $currentHostService*/

        return new ThemeEditorService($currentHostService, $themeRepository);
    }
}