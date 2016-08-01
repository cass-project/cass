<?php
namespace Application\Bootstrap\Scripts\AppInit;

use Application\Bootstrap\Scripts\AppInitScript;
use Application\Bundle\Bundle;
use Application\Exception\InvalidRouteDefinition;
use Application\Exception\UnknownRouteGroupException;
use Application\Exception\UnknownRouteTypeException;
use Application\Service\BundleService;
use Zend\Expressive\Application;

class RoutesSetupScript implements AppInitScript
{
    /** @var  Application $app */
    private $app;
    /** @var  array $routesGroup */
    private $routesGroup;

    public function __invoke(Application $app) {
        $this->app = $app;
        $this->routesGroup = $this->app->getContainer()->get("config.routes_group");
        $bundleService = $app->getContainer()->get(BundleService::class); /** @var BundleService $bundleService */

        $configDirs = array_map(function(Bundle $bundle) {
            return $bundle->getConfigDir();
        }, $bundleService->getBundles());

        $definitions = $this->getDefinitions($configDirs);

        $this->setupRoutes($definitions);
    }

    private function setupRoutes(array $definitions) {

        foreach($definitions as $groupName => $group){

            if(!in_array($groupName, $this->routesGroup)) throw new UnknownRouteGroupException(sprintf("unknow route group: %s", $groupName));
            foreach($group as $definition){
                switch($definition['type']){
                    default: throw new UnknownRouteTypeException(sprintf('unknoown type of definition: %s',$definition['type']) );
                    case 'route':
                        $this->setupRouteFromDefinition($definition);
                        break;
                    case 'pipe':
                        $this->setupPipeFromDefinition($definition);
                        break;
                }
            }
        }
    }

    private function getDefinitions( array $configDirs) : array {

        $definitions = [];
        foreach($configDirs as $configDir) {
            $routeConfigFile = sprintf('%s/%s', $configDir, 'routes.php');
            if(file_exists($routeConfigFile)) {
                $routes = require $routeConfigFile;
                if(is_array($routes)){
                    $definitions = array_merge_recursive($definitions, $routes);
                }
            }
        }

        return $this->sortByGroups($definitions);
    }

    private function sortByGroups(array $definitions):array
    {
        $routesGroups = $this->routesGroup;

        uksort($definitions,function($a,$b)use($routesGroups){
            return array_search($a,$routesGroups) > array_search($b, $routesGroups);
        });

        return $definitions;
    }

    private function setupRouteFromDefinition(array $definition){
        if(empty($definition['method'])){
            throw new InvalidRouteDefinition("missing required definition option - method");
        }
        if(empty($definition['url'])){
            throw new InvalidRouteDefinition("missing required definition option - url");
        }
        if(empty($definition['middleware'])){
            throw new InvalidRouteDefinition("missing required definition option - middleware");
        }
        if(empty($definition['name'])){
            throw new InvalidRouteDefinition("missing required definition option - name");
        }

        $method     = $definition['method'];
        $url        = $definition['url'];
        $middleware = $definition['middleware'];
        $name       = $definition['name'];

        $this->app->{$method}($url, $middleware, $name);
    }

    private function setupPipeFromDefinition(array $definition){
        $this->app->pipe($definition['middleware']);
    }
}