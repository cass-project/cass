<?php
namespace Application\Bootstrap;

use Application\Bootstrap\Scripts\AppInit\PipeMiddlewareScript;
use Application\Bootstrap\Scripts\AppInit\RoutesSetupScript;
use Application\Bootstrap\Scripts\Bootstrap\BundleServiceScript;
use Application\Bootstrap\Scripts\Bootstrap\BootstrapDIContainerScript;
use Application\Bootstrap\Scripts\Bootstrap\InjectSchemaServiceScript;
use Application\Bootstrap\Scripts\Bootstrap\ReadAppConfigScript;
use Application\PHPUnit\PHPUnitEmitter;
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
        BootstrapDIContainerScript::class,
        InjectSchemaServiceScript::class
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

    /** @var bool */
    private $useSAPIEmitter = true;

    public function __construct(array $rootBundles, array $initScripts = self::DEFAULT_INIT, array $initAppScripts = self::DEFAULT_INIT_APP) {
        $this->rootBundles = $rootBundles;
        $this->initScripts = $initScripts;
        $this->initAppScripts = $initAppScripts;
    }

    public function getRootBundles(): array {
        return $this->rootBundles;
    }

    public function enableSAPIEmitter(): self {
        $this->useSAPIEmitter = true;

        return $this;
    }

    public function disableSAPIEmitter(): self {
        $this->useSAPIEmitter = false;

        return $this;
    }

    public function setBundleService(BundleService $bundleService): self {
        $this->bundleService = $bundleService;

        return $this;
    }

    public function getBundleService(): BundleService {
        return $this->bundleService;
    }

    public function getConfigService(): ConfigService {
        return $this->configService;
    }

    public function setConfigService(ConfigService $configService): self {
        $this->configService = $configService;

        return $this;
    }

    public function getContainer(): Container {
        return $this->container;
    }

    public function setContainer(Container $container): self {
        $this->container = $container;

        return $this;
    }

    public function build(): Application {
        $router = new FastRouteRouter();
        $finalHandler = new FinalHandler();
        $emitter = new EmitterStack();

        if($this->useSAPIEmitter) {
            $emitter->push(new SapiEmitter());
        }else{
            $emitter->push(new PHPUnitEmitter());
        }

        foreach ($this->initScripts as $initScriptClassName) {
            $script = new $initScriptClassName;
            $script($this);
        }
        
        $app = new Application($router, $this->container, $finalHandler, $emitter);

        foreach ($this->initAppScripts as $initAppScriptClassName) {
            $script = new $initAppScriptClassName;
            $script($app);
        }

        $this->container->set(Application::class, $app);

        return $app;
    }
}