<?php
require __DIR__.'/vendor/autoload.php';

use Common\Bootstrap\Bundle\Bundle;
use Common\Bootstrap\Scripts\RouteSetupScript;
use Common\Bootstrap\Scripts\SharedConfigServiceSetupScript;
use Common\Service\SchemaService;
use Common\Service\SharedConfigService;
use Auth\Middleware\ProtectedMiddleware;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Expressive\Application;
use Zend\ServiceManager\ServiceManager;

class LBApplicationBootstrap
{
    /** @var Application */
    private $app;

    /** @var ServiceManager */
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
        $bundleService = new \Common\Bootstrap\Bundle\BundleService();
        $bundlesPath = $this->serviceManager->get('paths')['bundles'];

        $directories = array_filter(scandir($bundlesPath), function($input) use ($bundlesPath) {
            return $input != '.' && $input != '..' && is_dir(sprintf('%s/%s', $bundlesPath, $input));
        });

        foreach($directories as $directory) {
            $bundleName = $directory;
            $bundleClassName = sprintf('\%s\%sBundle', $bundleName, $bundleName);

            if(!class_exists($bundleClassName)) {
                throw new \Exception(sprintf('No Bundle available for bundle `%s`', $bundleName));
            }

            if(!is_subclass_of($bundleClassName, Bundle::class)) {
                throw new \Exception(sprintf('Bundle `%s` should implements interface %s', $bundleClassName, Bundle::class));
            }

            $bundleService->addBundle(new $bundleClassName());
        }

        $this->serviceManager->setService('Common\Bootstrap\Bundle\BundleService', $bundleService);
    }

    private function initContainer() {
        /** @var SharedConfigService $sharedConfigService */
        $sharedConfigService = $this->serviceManager->get(SharedConfigService::class);

        $this->serviceManager->configure(
            $sharedConfigService->get('zend_service_manager')
        );
    }

    private function initSharedConfigService() {
        (new SharedConfigServiceSetupScript($this->app, $this->serviceManager))->run();
    }

    private function initRoutes() {
        (new RouteSetupScript($this->app, $this->serviceManager))->run();
    }

    private function initSchemaRESTRequest() {
        \Common\Tools\RequestParams\SchemaParams::injectSchemaService($this->serviceManager->get(SchemaService::class));
    }

    private function initProtectedRoutes() {
        $this->app->pipe(ProtectedMiddleware::class);
    }

    /**
     * @return Application
     */
    public function getApp(): Application
    {
        return $this->app;
    }

    public function getServiceManager(): ServiceManager
    {
        return $this->serviceManager;
    }

    public function bootstrap() {
        $container = new ServiceManager();
        $router = new \Zend\Expressive\Router\FastRouteRouter();
        $errorHandler = new \Common\Bootstrap\ErrorHandler();
        $emitter = new \Zend\Expressive\Emitter\EmitterStack();
        $emitter->push(new SapiEmitter());

        $app = new Application($router, $container, $errorHandler, $emitter);

        $this->app = $app;
        $this->serviceManager = $app->getContainer();

        $this->initConstants();
        $this->initBundles();
        $this->initSharedConfigService();
        $this->initContainer();
        $this->initProtectedRoutes();
        $this->initRoutes();
        $this->initSchemaRESTRequest();
    }

    public function run() {
        $this->app->run();
    }
}

return new LBApplicationBootstrap();