<?php
namespace CASS\Application\REST;

use ZEA2\Platform\Bundles\REST\Response\Decorators\ResponseDecorator;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

final class SuccessResponseDecorator implements ResponseDecorator
{
    public function decorate(ResponseBuilder $builder, array $response): array
    {
        $success =
                 $builder->getStatus() === ResponseBuilder::CODE_SUCCESS
            && (! $builder->hasError());

        return $response + ['success' => $success];
    }
}