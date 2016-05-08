<?php
namespace Application\Frontline;

use DI\Container;
use Application\Frontline\Service\FrontlineService;

interface FrontlineBundleInjectable
{
    public function initFrontline(Container $container, FrontlineService $frontlineService);
}