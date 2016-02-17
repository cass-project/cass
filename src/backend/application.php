<?php
require __DIR__.'/vendor/autoload.php';

use Application\Bootstrap\Bundle\Bundle;
use Application\Bootstrap\Scripts\RouteSetupScript;
use Application\Bootstrap\Scripts\SharedConfigServiceSetupScript;
use Application\Service\SharedConfigService;
use Zend\Expressive\AppFactory;

class LBApplicationBootstrap
{
    /**
     * @var \Zend\Expressive\Application
     */
    private $app;

    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    private $serviceManager;

    private function initConstants() {
        $requiredConstants = [
            'LB_BACKEND_DIRECTORY',
            'LB_BACKEND_ROUTE_PREFIX',
            'LB_BACKEND_BUNDLES_DIR',
            'LB_FRONTEND_DIRECTORY',
            'LB_FRONTEND_BASE_URL',
        ];

        foreach($requiredConstants as $required) {
            if(!defined($required)) {
                throw new \Exception(sprintf('Constant `%s` is required', $required));
            }
        }

        $this->serviceManager->setService('paths', [
            'prefix' => LB_BACKEND_ROUTE_PREFIX,
            'backend' => LB_BACKEND_DIRECTORY,
            'bundles' => LB_BACKEND_BUNDLES_DIR,
            'frontend' => LB_FRONTEND_DIRECTORY
        ]);
    }

    private function initBundles() {
        $bundleService = new \Application\Bootstrap\Bundle\BundleService();
        $bundlesPath = $this->serviceManager->get('paths')['bundles'];

        $directories = array_filter(scandir($bundlesPath), function($input) use ($bundlesPath) {
            return is_dir(sprintf('%s/%s', $bundlesPath, $input))
                && preg_match('/^(.*)Bundle$/', $input);
        });

        foreach($directories as $directory) {
            $bundleName = substr($directory, 0, -6);
            $bundleClassName = sprintf('\%s\%sBundle', $bundleName, $bundleName);

            if(!class_exists($bundleClassName)) {
                throw new \Exception(sprintf('No Bundle available for bundle `%s`', $bundleName));
            }

            if(!is_subclass_of($bundleClassName, Bundle::class)) {
                throw new \Exception(sprintf('Bundle `%s` should implements interface %s', $bundleClassName, Bundle::class));
            }

            $bundleService->addBundle(new $bundleClassName());
        }

        $this->serviceManager->setService('Application\Bootstrap\Bundle\BundleService', $bundleService);
    }

    private function initContainer() {
        /** @var SharedConfigService $sharedConfigService */
        $sharedConfigService = $this->serviceManager->get(SharedConfigService::class);

        $this->serviceManager->configure(
            $sharedConfigService->get('zend_service_manager')
        );
    }

    private function initSharedConfigService() {
        (new SharedConfigServiceSetupScript())->run($this->app, $this->serviceManager);
    }

    private function initRoutes() {
        (new RouteSetupScript())->run($this->app, $this->serviceManager);
    }

    public function bootstrap() {
        $app = AppFactory::create();

        $this->app = $app;
        $this->serviceManager = $app->getContainer();

        $this->initConstants();
        $this->initBundles();
        $this->initSharedConfigService();
        $this->initContainer();
        $this->initRoutes();

        $app->run();
    }
}

(new LBApplicationBootstrap())->bootstrap();