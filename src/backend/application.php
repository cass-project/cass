<?php
require __DIR__ . '/vendor/autoload.php';

use Common\Bootstrap\Bundle\Bundle;
use Common\Bootstrap\Bundle\BundleService;
use Common\Bootstrap\Scripts\RouteSetupScript;
use Common\Bootstrap\Scripts\ReadAppConfigScript;
use Common\Service\SchemaService;
use Common\Service\SharedConfigService;
use Auth\Middleware\ProtectedMiddleware;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Expressive\Application;

class LBApplicationBootstrap
{
    /** @var Application */
    private $app;

    /** @var SharedConfigService */
    private $config;

    /** @var LBAppConstants */
    private $paths;

    /** @var BundleService */
    private $bundles;

    /** @var \DI\Container */
    private $container;

    public function bootstrap() {
        $router = new \Zend\Expressive\Router\FastRouteRouter();
        $errorHandler = new \Common\Bootstrap\ErrorHandler();
        $emitter = new \Zend\Expressive\Emitter\EmitterStack();
        $emitter->push(new SapiEmitter());

        $app = new Application($router, $this->container, $errorHandler, $emitter);

        $this->app = $app;

        $this->initConstants();
        $this->initBundlesService();
        $this->initAppConfig();
        $this->initDI();
        $this->initProtectedRoutes();
        $this->initRoutes();
        $this->initSchemaRESTRequest();
    }

    public function run() {
        $this->app->run();
    }

    private function initConstants() {
        $requiredConstants = [
            'LB_BACKEND_DIRECTORY',
            'LB_BACKEND_ROUTE_PREFIX',
            'LB_BACKEND_BUNDLES_DIR',
            'LB_FRONTEND_DIRECTORY',
            'LB_FRONTEND_BASE_URL',
            'LB_STORAGE_DIRECTORY',
        ];

        foreach ($requiredConstants as $required) {
            if (!defined($required)) {
                throw new \Exception(sprintf('Constant `%s` is required', $required));
            }
        }

        $this->paths = new LBAppConstants(
            LB_BACKEND_ROUTE_PREFIX,
            LB_BACKEND_DIRECTORY,
            LB_BACKEND_BUNDLES_DIR,
            LB_FRONTEND_DIRECTORY,
            LB_STORAGE_DIRECTORY
        );
    }

    private function initBundlesService() {
        $bundleService = new BundleService();
        $bundlesPath = $this->paths->bundles();

        $directories = array_filter(scandir($bundlesPath), function ($input) use ($bundlesPath) {
            return $input != '.' && $input != '..' && is_dir(sprintf('%s/%s', $bundlesPath, $input));
        });

        foreach ($directories as $directory) {
            $bundleName = $directory;
            $bundleClassName = sprintf('\%s\%sBundle', $bundleName, $bundleName);

            if (!class_exists($bundleClassName)) {
                throw new \Exception(sprintf('No Bundle available for bundle `%s`', $bundleName));
            }

            if (!is_subclass_of($bundleClassName, Bundle::class)) {
                throw new \Exception(sprintf('Bundle `%s` should implements interface %s', $bundleClassName, Bundle::class));
            }

            $bundleService->addBundle(new $bundleClassName());
        }

        $this->bundles = $bundleService;
    }

    private function initAppConfig() {
        $this->config = new SharedConfigService();

        $script = new ReadAppConfigScript($this->paths->backend());
        $script($this->config, $this->bundles->getBundles());
    }

    private function initDI() {
        $containerBuilder = new \DI\ContainerBuilder();
        $containerBuilder->addDefinitions($this->config->get('php-di'));

        $this->container = $containerBuilder->build();
    }

    private function initProtectedRoutes() {
        $this->app->pipe(ProtectedMiddleware::class);
    }

    private function initRoutes() {
        $script = new RouteSetupScript();
        $script($this->app, $this->bundles->getConfigDirs(), $this->paths->prefix());
    }

    private function initSchemaRESTRequest() {
        \Common\Tools\RequestParams\SchemaParams::injectSchemaService($this->container->get(SchemaService::class));
    }
}


class LBAppConstants
{
    /** @var string */
    private $prefix;

    /** @var string */
    private $backend;

    /** @var string */
    private $bundles;

    /** @var string */
    private $frontend;

    /** @var string */
    private $storage;

    public function __construct(string $prefix, string $backend, string $bundles, string $frontend, string $storage) {
        $this->prefix = $prefix;
        $this->backend = $backend;
        $this->bundles = $bundles;
        $this->frontend = $frontend;
        $this->storage = $storage;
    }

    public function prefix() {
        return $this->prefix;
    }

    public function backend() {
        return $this->backend;
    }

    public function bundles() {
        return $this->bundles;
    }

    public function frontend() {
        return $this->frontend;
    }

    public function storage() {
        return $this->storage;
    }
}

return new LBApplicationBootstrap();