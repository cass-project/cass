<?php
namespace Application\Bootstrap\Scripts\AppInit;

use Application\Bootstrap\Scripts\AppInitScript;
use Zend\Expressive\Application;

class PipeMiddlewareScript implements AppInitScript
{
    public function __invoke(Application $app) {
        $app->pipeRoutingMiddleware();
        $app->pipeDispatchMiddleware();
    }
}