<?php
namespace CASS\Application\REST;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use ZEA2\Platform\Bundles\REST\Response\ResponseDecoratorsManager;

final class CASSResponseBuilder extends ResponseBuilder
{
    protected function initDecorators(ResponseDecoratorsManager $decoratorsManager)
    {
        $decoratorsManager
            ->attach(new SuccessResponseDecorator())
            ->attach(new TimeResponseDecorator())
            ->attach(new ErrorResponseDecorator())
        ;
    }
}