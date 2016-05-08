<?php
namespace Application\Common\Bootstrap\Bundle;

use DI\Container;
use Application\Frontline\Service\FrontlineService;

interface FrontlineBundleInjectable
{
    public function initFrontline(Container $container, FrontlineService $frontlineService);
}