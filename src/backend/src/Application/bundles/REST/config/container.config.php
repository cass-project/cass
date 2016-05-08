<?php
namespace Application\REST;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Service\BundleService;
use Application\REST\Service\SchemaService;

return [
    'php-di' => [
        SchemaService::class => object()->constructor(get(BundleService::class))
    ]
];