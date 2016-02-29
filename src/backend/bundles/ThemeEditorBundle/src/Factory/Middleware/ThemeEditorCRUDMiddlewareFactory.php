<?php
namespace ThemeEditor\Factory\Middleware;

use Application\Service\SchemaService;
use Interop\Container\ContainerInterface;
use ThemeEditor\Middleware\ThemeEditorCRUDMiddleware;
use ThemeEditor\Service\ThemeEditorService;
use Zend\ServiceManager\Factory\FactoryInterface;

class ThemeEditorCRUDMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): ThemeEditorCRUDMiddleware
    {
        $themeEditorService = $container->get(ThemeEditorService::class); /** @var ThemeEditorService $themeEditorService */
        $schemaService = $container->get(SchemaService::class); /** @var SchemaService $schemaService */

        return new ThemeEditorCRUDMiddleware($themeEditorService, $schemaService);
    }
}