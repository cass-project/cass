<?php
namespace Common\Bootstrap\Bundle;

use DI\Container;
use Frontline\Service\FrontlineService;

interface FrontlineBundleInjectable
{
    public function initFrontline(Container $container, FrontlineService $frontlineService);
}