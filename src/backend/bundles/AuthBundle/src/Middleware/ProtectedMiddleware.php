<?php
namespace Auth\Middleware;

use Application\REST\GenericRESTResponseBuilder;
use Auth\Service\CurrentProfileService;
use Auth\Service\NotAuthenticatedException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProtectedMiddleware implements MiddlewareInterface
{
    /** @var CurrentProfileService */
    private $currentProfileService;

    /** @var string */
    private $prefix;

    public function __construct(CurrentProfileService $currentProfileService, string $prefix)
    {
        $this->currentProfileService = $currentProfileService;
        $this->prefix = $prefix;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $isURLProtectedByHeader = strpos($request->getUri()->getPath(), "{$this->prefix}/protected/") === 0;
        $isURLProtectedByJSONBody = strpos($request->getUri()->getPath(), "{$this->prefix}/protected-body/") === 0;

        try {
            if($isURLProtectedByHeader) {
                $this->currentProfileService->setupAccountFromHeader($request);
            }else if($isURLProtectedByJSONBody) {
                $this->currentProfileService->setupAccountFromJSONBody($request);
            }

            return $out($request, $response);
        }catch(NotAuthenticatedException $e) {
            $responseBuilder = new GenericRESTResponseBuilder($response);

            return $responseBuilder
                ->setStatusBadRequest()
                ->setError($e)
                ->build()
            ;
        }
    }
}