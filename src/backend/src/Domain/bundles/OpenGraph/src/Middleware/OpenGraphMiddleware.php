<?php
namespace Domain\OpenGraph\Middleware;

use Application\REST\Response\GenericResponseBuilder;
use Domain\OpenGraph\Exception\InvalidURLException;
use Domain\OpenGraph\Service\OpenGraphService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

final class OpenGraphMiddleware implements MiddlewareInterface
{
    /** @var OpenGraphService */
    private $openGraphService;

    public function __construct(OpenGraphService $openGraphService)
    {
        $this->openGraphService = $openGraphService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericResponseBuilder($response);

        try {
            $url = $request->getQueryParams()['url'] ?? '';
            $res = $this->openGraphService->getOPG($url);

            $responseBuilder
                ->setJson([
                    'entity' => $res,
                ])
                ->setStatusSuccess();
        }catch(InvalidURLException $e){
            $responseBuilder
                ->setError($e)
                ->setStatusBadRequest();
        }

        return $responseBuilder->build();
    }
}