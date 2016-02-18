<?php
namespace ThemeEditor\Factory\Middleware;

use Interop\Container\ContainerInterface;
use ThemeEditor\Middleware\ThemeEditorCRUDMiddleware;
use ThemeEditor\Service\ThemeEditorService;
use Zend\ServiceManager\Factory\FactoryInterface;

class ThemeEditorCRUDMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ThemeEditorService $themeEditorService */
        $themeEditorService = $container->get(ThemeEditorService::class);

        return new ThemeEditorCRUDMiddleware($themeEditorService);
    }
}