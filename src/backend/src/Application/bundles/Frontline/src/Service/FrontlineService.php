<?php
namespace CASS\Application\Frontline\Service;

use CASS\Application\Bundle\Bundle;
use CASS\Application\Frontline\FrontlineBundleInjectable;
use CASS\Application\Frontline\FrontlineScript;
use CASS\Application\Frontline\Service\FrontlineService\Filter;
use CASS\Application\Service\BundleService;
use Cocur\Chain\Chain;
use DI\Container;

class HasExporterWithSameIdException extends \Exception {}

class FrontlineService
{
    /** @var Container */
    private $container;
    
    /** @var BundleService */
    private $bundlesService;

    public function __construct(
        Container $container,
        BundleService $bundlesService)
    {
        $this->container = $container;
        $this->bundlesService = $bundlesService;
    }

    public function fetch(Filter $filter): array {
        $result = [];
        $scripts = Chain::create($this->bundlesService->getBundles())
            ->filter(function(Bundle $bundle) {
                return $bundle instanceof FrontlineBundleInjectable;
            })
            ->map(function(FrontlineBundleInjectable $bundle) {
                return $bundle->getFrontlineScripts();
            })
            ->reduce(function(array $carry, array $scripts) {
                return array_merge($carry, $scripts);
            }, [])
        ;

        $scripts = array_map(function(string $script) {
            return $this->container->get($script);
        }, $scripts);

        foreach($filter->filter($scripts) as $script) {
            if($script instanceof FrontlineScript) {
                $result = array_merge_recursive($result, $script());
            }else{
                throw new \Exception;
            }
        }

        return $result;
    }
}