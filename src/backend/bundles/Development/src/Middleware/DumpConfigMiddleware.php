<?php
namespace Development\Middleware;

use Common\REST\GenericRESTResponseBuilder;
use Development\Middleware\Exception\DevelopmentToolsAreNotEnabledException;
use Development\Middleware\Exception\UnknownSourceException;
use Development\Service\DumpConfigService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\Http\ResponseInterface;
use Zend\Stratigility\MiddlewareInterface;

class DumpConfigMiddleware implements MiddlewareInterface
{
    const SOURCE_ALL = 'all';
    const SOURCE_APPLICATION = 'application';
    const SOURCE_PROVIDE = 'provide';
    const SOURCE_CONTAINER = 'container';

    /**
     * @var DumpConfigService
     */
    private $dumpConfigService;

    /**
     * @var bool
     */
    private $isEnabled;

    public function __construct($isEnabled, DumpConfigService $dumpConfigService)
    {
        $this->isEnabled = $isEnabled;
        $this->dumpConfigService = $dumpConfigService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null): ResponseInterface
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);

        try {
            if(!($this->isEnabled)) {
                throw new DevelopmentToolsAreNotEnabledException('gr8 scripts m8 but no hax allowed');
            }

            $config = $this->getConfig($request);

            $responseBuilder->setJson($config);
            $responseBuilder->setStatusSuccess();
        }catch(UnknownSourceException $e){
            $responseBuilder->setStatusBadRequest();
            $responseBuilder->setError($e);
        }catch(DevelopmentToolsAreNotEnabledException $e){
            $responseBuilder->setStatusBadRequest();
            $responseBuilder->setError($e);
        }

        return $responseBuilder->build();
    }

    private function getConfig(Request $request): array
    {
        $source = $request->getAttribute('source');
        $dumpConfigService = $this->dumpConfigService;

        switch ($source) {
            default:
                throw new UnknownSourceException('Unknown source `%s`. Use one of these: all, provide, application');

            case self::SOURCE_ALL:
                return $dumpConfigService->getOverallConfiguration();

            case self::SOURCE_APPLICATION:
                return $dumpConfigService->getApplicationConfiguration();

            case self::SOURCE_PROVIDE:
                return $dumpConfigService->getProvideConfiguration();

            case self::SOURCE_CONTAINER:
                return $dumpConfigService->getContainerConfiguration();
        }
    }
}