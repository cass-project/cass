<?php
namespace Domain\Feed;

use DI\Container;
use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Feed\Service\FeedService;

return [
    'php-di' => [
        FeedService::class => object()
            ->constructorParameter('sources', function(Container $container) {
                return [
                    
                ];
            })
    ]
];