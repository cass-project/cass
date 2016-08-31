<?php
namespace CASS\Application\Bootstrap;

use DI\Container;
use CASS\Application\Bootstrap\Scripts\AppInit\EventsSetupScript;
use CASS\Application\Bootstrap\Scripts\AppInit\PipeMiddlewareScript;
use CASS\Application\Bootstrap\Scripts\AppInit\RoutesSetupScript;
use CASS\Application\Bootstrap\Scripts\Bootstrap\BundleServiceScript;
use CASS\Application\Bootstrap\Scripts\Bootstrap\BootstrapDIContainerScript;
use CASS\Application\Bootstrap\Scripts\Bootstrap\InjectSchemaServiceScript;
use CASS\Application\Bootstrap\Scripts\Bootstrap\ReadAppConfigScript;
use ZEA2\Platform\Bundles\PHPUnit\PHPUnitEmitter;
use CASS\Application\Service\BundleService;
use CASS\Application\Service\ConfigService;
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
        EventsSetupScript::class,
        PipeMiddlewareScript::class,
    ];

    /** @var string */
    private $env;

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

    public function __construct(
        array $rootBundles,
        array $initScripts = self::DEFAULT_INIT,
        array $initAppScripts = self::DEFAULT_INIT_APP
    )
    {
        $this->rootBundles = $rootBundles;
        $this->initScripts = $initScripts;
        $this->initAppScripts = $initAppScripts;
    }

    public function build($env = null): Application
    {
        $this->env = $env;

        $router = new FastRouteRouter();
        $finalHandler = new FinalHandler();
        $emitter = new EmitterStack();

        if($this->useSAPIEmitter) {
            $emitter->push(new SapiEmitter());
        } else {
            $emitter->push(new PHPUnitEmitter());
        }

        foreach($this->initScripts as $initScriptClassName) {
            $script = new $initScriptClassName;
            $script($this);
        }

        $app = new Application($router, $this->container, $finalHandler, $emitter);

        foreach($this->initAppScripts as $initAppScriptClassName) {
            $script = new $initAppScriptClassName;
            $script($app);
        }

        $this->container->set(Application::class, $app);

        return $app;
    }

    public function isEnvSpecified(): bool
    {
        return $this->env !== null;
    }

    public function getEnv(): string
    {
        return $this->env;
    }

    public function getRootBundles(): array
    {
        return $this->rootBundles;
    }

    public function enableSAPIEmitter(): self
    {
        $this->useSAPIEmitter = true;

        return $this;
    }

    public function disableSAPIEmitter(): self
    {
        $this->useSAPIEmitter = false;

        return $this;
    }

    public function setBundleService(BundleService $bundleService): self
    {
        $this->bundleService = $bundleService;

        return $this;
    }

    public function getBundleService(): BundleService
    {
        return $this->bundleService;
    }

    public function getConfigService(): ConfigService
    {
        return $this->configService;
    }

    public function setConfigService(ConfigService $configService): self
    {
        $this->configService = $configService;

        return $this;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function setContainer(Container $container): self
    {
        $this->container = $container;

        return $this;
    }
}