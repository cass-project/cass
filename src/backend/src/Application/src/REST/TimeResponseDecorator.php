<?php
namespace CASS\Application\REST;

use ZEA2\Platform\Bundles\REST\Response\Decorators\ResponseDecorator;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

final class TimeResponseDecorator implements ResponseDecorator
{
    public function decorate(ResponseBuilder $builder, array $response): array
    {
        if(defined('APP_TIMER_START')) {
            return $response + ['time' => (microtime(true) - APP_TIMER_START).'ms'];
        }else{
            return $response;
        }
    }
}