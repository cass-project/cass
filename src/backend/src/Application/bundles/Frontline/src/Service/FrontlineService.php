<?php
namespace Application\Frontline\Service;

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

    public function fetchFrontlineResult(): array 
    {
        $result = [];

        foreach ($this->bundlesService->getBundles() as $bundle) {
            if($bundle instanceof FrontlineBundleInjectable) {
                $result = array_merge_recursive($result, $this->traverse($bundle->getFrontlineScripts()));
            }
        }

        return $result;
    }

    private function traverse(array $scripts) {
        $result = [];

        foreach($scripts as $key => $script) {
            if(is_array($script)) {
                $result[$key] = $this->traverse($script);
            }else if(is_string($script)) {
                $script = $this->container->get($script);

                if(is_callable($script)) {
                    $result[$key] = $script($this->container);
                }else{
                    throw new \Exception('Invalid frontline script');
                }
            }else if(is_callable($script)) {
                $result[$key] = $script($this->container);
            }else{
                throw new \Exception('Invalid frontline script');
            }
        }

        return $result;
    }
}