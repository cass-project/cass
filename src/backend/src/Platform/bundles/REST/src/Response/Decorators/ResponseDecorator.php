<?php
namespace ZEA2\Platform\Bundles\REST\Response\Decorators;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

interface ResponseDecorator
{
    public function decorate(ResponseBuilder $builder, array $response): array;
}