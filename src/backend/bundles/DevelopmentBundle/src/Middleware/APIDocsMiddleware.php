<?php
namespace Development\Middleware;

use Application\REST\GenericRESTResponseBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Development\Service\APIDocsService;
use Zend\Stratigility\MiddlewareInterface;

class APIDocsMiddleware implements MiddlewareInterface
{
    /**
     * @var APIDocsService
     */
    private $apiDocsService;

    /**
     * APIDocsMiddleware constructor.
     * @param APIDocsService $apiDocsService
     */
    public function __construct(APIDocsService $apiDocsService)
    {
        $this->apiDocsService = $apiDocsService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $restResponseBuilder = new GenericRESTResponseBuilder($response);
        $restResponseBuilder->setJson($this->apiDocsService->buildAPIDocs());
        $restResponseBuilder->setStatusSuccess();

        return $restResponseBuilder->build();
    }
}