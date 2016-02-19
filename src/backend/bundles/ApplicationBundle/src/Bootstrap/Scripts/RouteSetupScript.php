<?php
namespace Application\Bootstrap\Scripts;

use Application\Bootstrap\Bundle\BundleService;
use Zend\Expressive\Application;
use Zend\ServiceManager\ServiceManager;

class RouteSetupScript
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var ServiceManager
     */
    private $zendServiceManager;

    public function __construct(Application $app, ServiceManager $zendServiceManager)
    {
        $this->app = $app;
        $this->zendServiceManager = $zendServiceManager;
    }

    public function run()
    {
        $app = $this->app;
        $serviceManager = $this->zendServiceManager;

        /** @var BundleService $bundlesService */
        $bundlesService = $serviceManager->get(BundleService::class);
        $prefix = $serviceManager->get('paths')['prefix'];

        foreach($bundlesService->getConfigDirs() as $configDir) {
            $routeConfigFile = sprintf('%s/routes.php', $configDir);

            if(file_exists($routeConfigFile)) {
                $callback = require $routeConfigFile;

                if(!is_callable($callback)) {
                    throw new \Exception(sprintf('Config `%s` should returns a Callable with Application and prefix argument', $routeConfigFile));
                }

                $callback($app, $prefix);
            }
        }
    }
}