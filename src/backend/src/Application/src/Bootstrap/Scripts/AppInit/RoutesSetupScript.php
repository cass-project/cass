<?php
namespace Application\Bootstrap\Scripts\AppInit;

use Application\Bootstrap\Scripts\AppInitScript;
use Application\Bundle\Bundle;
use Application\Service\BundleService;
use Zend\Expressive\Application;

class RoutesSetupScript implements AppInitScript
{
    public function __invoke(Application $app) {
        $bundleService = $app->getContainer()->get(BundleService::class); /** @var BundleService $bundleService */

        $configDirs = array_map(function(Bundle $bundle) {
            return $bundle->getConfigDir();
        }, $bundleService->getBundles());

        $definitions = $this->getDefinitions($configDirs );


        uksort($definitions,function($a,$b){

        });

        print_r($definitions);
        die();


    }

    private function setupRoutes(Application $app, string $configDir, string $routeFile) {


    }

    private function getDefinitions( array $configDirs) : array {

        $definitions = [];
        foreach($configDirs as $configDir) {
            $routeConfigFile = sprintf('%s/%s', $configDir, 'routes.before.php');
            if(file_exists($routeConfigFile)) {
                $routes = require $routeConfigFile;
                if(is_array($routes)){
                    $definitions = array_merge_recursive($definitions, $routes);
                }
            }

            $routeConfigFile = sprintf('%s/%s', $configDir, 'routes.php');
            if(file_exists($routeConfigFile)) {
                $routes = require $routeConfigFile;
                if(is_array($routes)){
                    $definitions = array_merge_recursive($definitions, $routes);
                }
            }

            $routeConfigFile = sprintf('%s/%s', $configDir, 'routes.after.php');
            if(file_exists($routeConfigFile)) {
                $routes = require $routeConfigFile;
                if(is_array($routes)){
                    $definitions = array_merge_recursive($definitions, $routes);
                }
            }
        }

        return $definitions;
    }

    private function createRouteFromDefinition(Application $app, array $definition){
        if(empty($definition['method'])||
           $definition['url'] ||
           $definition['middleware'] ||
           $definition['name']
        ) throw new \Exception("missing required definition option");

        $method     = $definition['method'];
        $url        = $definition['url'];
        $middleware = $definition['middleware'];
        $name       = $definition['name'];


        $app->{$method}( $url, $middleware, $name );
    }
    private function createPipeFromDefinition(Application $app,array $definition){

        $app->pipe($definition['middleware']);
    }
}