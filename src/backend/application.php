<?php
require __DIR__ . '/vendor/autoload.php';

use Common\Bootstrap\Bundle\Bundle;
use Common\Bootstrap\Bundle\BundleService;
use Common\Bootstrap\Scripts\RouteSetupScript;
use Common\Bootstrap\Scripts\ReadAppConfigScript;
use Common\Service\SchemaService;
use Common\Service\SharedConfigService;
use Auth\Middleware\ProtectedMiddleware;
use Frontline\Service\FrontlineService;
use ProfileIM\Middleware\ProfileIMMiddleware;
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
        $this->initConstants();
        $this->initBundlesService();
        $this->initAppConfig();
        $this->initDI();
        $this->initPHPSAPI();

        $this->initFrontline();
    }

    public function run() {
        $router = new \Zend\Expressive\Router\FastRouteRouter();
        $errorHandler = new \Common\Bootstrap\ErrorHandler();
        $emitter = new \Zend\Expressive\Emitter\EmitterStack();
        $emitter->push(new SapiEmitter());

        $this->app = new Application($router, $this->container, $errorHandler, $emitter);

        $this->initProtectedRoutes();
        $this->initRoutes();
        $this->initSchemaRESTRequest();

        $this->container->get(ProfileIMMiddleware::class);

        $this->app->run();
    }

    public function getContainer(): \Interop\Container\ContainerInterface {
        return $this->container;
    }

    public function getAppConfig(): SharedConfigService
    {
        return $this->container->get(SharedConfigService::class);
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

    private function initPHPSAPI()
    {
        $this->container->set("PHP_SAPI_NAME", php_sapi_name());
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
        $containerBuilder->addDefinitions([
            BundleService::class => $this->bundles,
            SharedConfigService::class => $this->config,
        ]);
        $containerBuilder->addDefinitions([
            'constants.backend' => $this->paths->backend(),
            'constants.bundles' => $this->paths->bundles(),
            'constants.frontend' => $this->paths->frontend(),
            'constants.prefix' => $this->paths->prefix(),
            'constants.storage' => $this->paths->storage(),
        ]);

        $this->container = $containerBuilder->build();
    }

    private function initFrontline() {
        $container = $this->container;
        $frontlineService = $container->get(FrontlineService::class);

        foreach($this->bundles->getBundles() as $bundle) {
            if($bundle instanceof \Common\Bootstrap\Bundle\FrontlineBundleInjectable) {
                $bundle->initFrontline($container, $frontlineService);
            }
        }
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

    public function prefix(): string {
        return $this->prefix;
    }

    public function backend(): string {
        return $this->backend;
    }

    public function bundles(): string {
        return $this->bundles;
    }

    public function frontend(): string {
        return $this->frontend;
    }

    public function storage(): string {
        return $this->storage;
    }
}

return new LBApplicationBootstrap();