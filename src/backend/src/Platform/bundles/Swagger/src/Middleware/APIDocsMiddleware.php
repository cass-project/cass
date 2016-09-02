<?php
namespace ZEA2\Platform\Bundles\Swagger\Middleware;

use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ZEA2\Platform\Bundles\Swagger\Service\APIDocsService;
use Zend\Stratigility\MiddlewareInterface;

class APIDocsMiddleware implements MiddlewareInterface
{
    /**
     * @var \ZEA2\Platform\Bundles\Swagger\Service\APIDocsService
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
        $restResponseBuilder = new GenericResponseBuilder($response);
        $restResponseBuilder->setJson($this->apiDocsService->buildAPIDocs());
        $restResponseBuilder->setStatusSuccess();

        return $restResponseBuilder->build();
    }
}