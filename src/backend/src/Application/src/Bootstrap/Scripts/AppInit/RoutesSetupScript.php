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

        foreach($configDirs as $configDir) {
            $this->setupRoutes($app, $configDir, 'routes.before.php');
        }

        foreach($configDirs as $configDir) {
            $this->setupRoutes($app, $configDir, 'routes.php');
        }

        foreach($configDirs as $configDir) {
            $this->setupRoutes($app, $configDir, 'routes.after.php');
        }
    }

    private function setupRoutes(Application $app, string $configDir, string $routeFile) {
        $routeConfigFile = sprintf('%s/%s', $configDir, $routeFile);

        if(file_exists($routeConfigFile)) {
            $callback = require $routeConfigFile;

            if(!is_callable($callback)) {
                throw new \Exception(sprintf('Config `%s` should returns a Callable with Application argument', $routeConfigFile));
            }

            $callback($app);
        }
    }
}