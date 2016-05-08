<?php
namespace Application\Auth\Middleware;

use Application\Common\REST\GenericRESTResponseBuilder;
use Application\Auth\Middleware\AuthStrategy\HeaderStrategy;
use Application\Auth\Middleware\AuthStrategy\JSONBodyStrategy;
use Application\Auth\Middleware\AuthStrategy\SessionStrategy;
use Application\Auth\Service\CurrentAccountService;
use Application\Auth\Service\NotAuthenticatedException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProtectedMiddleware implements MiddlewareInterface
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var string */
    private $prefix;

    public function __construct(CurrentAccountService $currentAccountService, string $prefix)
    {
        $this->currentAccountService = $currentAccountService;
        $this->prefix = $prefix;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $isURLProtected = strpos($request->getUri()->getPath(), "{$this->prefix}/protected/") === 0;

        try {
            $this->currentAccountService->attempt([
                new HeaderStrategy($request),
                new JSONBodyStrategy($request),
                new SessionStrategy($request)
            ]);
        }catch(NotAuthenticatedException $e) {
            if($isURLProtected) {
                $responseBuilder = new GenericRESTResponseBuilder($response);

                return $responseBuilder
                    ->setStatusBadRequest()
                    ->setError($e)
                    ->build()
                    ;
            }
        }

        return $out($request, $response);
    }
}