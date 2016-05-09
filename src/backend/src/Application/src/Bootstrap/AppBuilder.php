<?php
namespace Application\Bootstrap;

use Application\Bootstrap\Scripts\AppInit\PipeMiddlewareScript;
use Application\Bootstrap\Scripts\AppInit\RoutesSetupScript;
use Application\Bootstrap\Scripts\Bootstrap\BundleServiceScript;
use Application\Bootstrap\Scripts\Bootstrap\BootstrapDIContainerScript;
use Application\Bootstrap\Scripts\Bootstrap\ReadAppConfigScript;
use Application\Service\BundleService;
use Application\Service\ConfigService;
use DI\Container;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Expressive\Application;
use Zend\Expressive\Emitter\EmitterStack;
use Zend\Expressive\Router\FastRouteRouter;

class AppBuilder
{
    const DEFAULT_INIT = [
        BundleServiceScript::class,
        ReadAppConfigScript::class,
        BootstrapDIContainerScript::class
    ];
    
    const DEFAULT_INIT_APP = [
        RoutesSetupScript::class,
        PipeMiddlewareScript::class
    ];

    /** @var string[] */
    private $rootBundles;

    /** @var string[] */
    private $initScripts = [];

    /** @var string[] */
    private $initAppScripts = [];

    /** @var BundleService */
    private $bundleService;

    /** @var ConfigService */
    private $configService;

    /** @var Container */
    private $container;

    public function __construct(array $rootBundles, array $initScripts = self::DEFAULT_INIT, array $initAppScripts = self::DEFAULT_INIT_APP) {
        $this->rootBundles = $rootBundles;
        $this->initScripts = $initScripts;
        $this->initAppScripts = $initAppScripts;
    }

    public function getRootBundles(): array {
        return $this->rootBundles;
    }

    public function setBundleService(BundleService $bundleService) {
        $this->bundleService = $bundleService;
    }

    public function getBundleService(): BundleService {
        return $this->bundleService;
    }

    public function getConfigService(): ConfigService {
        return $this->configService;
    }

    public function setConfigService(ConfigService $configService) {
        $this->configService = $configService;
    }

    public function getContainer(): Container {
        return $this->container;
    }

    public function setContainer(Container $container) {
        $this->container = $container;
    }

    public function build(): Application {
        $router = new FastRouteRouter();
        $finalHandler = new FinalHandler();
        $emitter = new EmitterStack();
        $emitter->push(new SapiEmitter());

        foreach ($this->initScripts as $initScriptClassName) {
            $script = new $initScriptClassName;
            $script($this);
        }

        $app = new Application($router, $this->container, $finalHandler);

        foreach ($this->initAppScripts as $initAppScriptClassName) {
            $script = new $initAppScriptClassName;
            $script($app);
        }

        return $app;
    }
}