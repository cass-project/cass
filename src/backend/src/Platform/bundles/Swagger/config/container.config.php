<?php
namespace ZEA2\Platform\Bundles\Swagger;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use ZEA2\Platform\Bundles\Swagger\Service\APIDocsService;

return [
    'php-di' => [
        APIDocsService::class => object()
            ->constructorParameter('excludedBundles', factory(function(Container $container): array {
                if($container->has('config.api-docs.excluded-bundles')) {
                    return $container->get('config.api-docs.excluded-bundles');
                }else{
                    return [];
                }
            }))
    ]
];