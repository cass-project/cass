<?php
namespace Application\Frontline\Service;

use Domain\Auth\Frontline\AuthTokenScript;
use Application\Frontline\FrontlineBundleInjectable;
use Application\Service\BundleService;
use DI\Container;

class HasExporterWithSameIdException extends \Exception {}

class FrontlineService
{
    /** @var Container */
    private $container;
    
    /** @var BundleService */
    private $bundlesService;

    public function __construct(Container $container, BundleService $bundlesService)
    {
        $this->container = $container;
        $this->bundlesService = $bundlesService;
    }

    public function fetchFrontlineResult()
    {
        $result = [];

        foreach ($this->bundlesService->getBundles() as $bundle) {
            if($bundle instanceof FrontlineBundleInjectable) {
                foreach($bundle->getFrontlineScripts() as $key => $scriptName) {
                    if(isset($result[$key])) {
                        throw new \Exception(sprintf('Overwrite attempt by frontline script `%s`', $scriptName));
                    }

                    $script = $this->container->get($scriptName);
                    $result[$key] = $script($this->container);
                }
            }
        }

        return $result;
    }
}