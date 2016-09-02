<?php
namespace CASS\Domain\Auth\Middleware;

use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use CASS\Domain\Auth\Middleware\AuthStrategy\HeaderStrategy;
use CASS\Domain\Auth\Middleware\AuthStrategy\JSONBodyStrategy;
use CASS\Domain\Auth\Middleware\AuthStrategy\SessionStrategy;
use CASS\Domain\Auth\Service\CurrentAccountService;
use CASS\Domain\Auth\Exception\NotAuthenticatedException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProtectedMiddleware implements MiddlewareInterface
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    public function __construct(CurrentAccountService $currentAccountService)
    {
        $this->currentAccountService = $currentAccountService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $isURLProtected = strpos($request->getUri()->getPath(), "/protected/") === 0;

        try {
            $this->currentAccountService->signInWithStrategies([
                new HeaderStrategy($request),
                new JSONBodyStrategy($request),
                new SessionStrategy($request)
            ]);
        }catch(NotAuthenticatedException $e) {
            if($isURLProtected) {
                $responseBuilder = new GenericResponseBuilder($response);

                return $responseBuilder
                    ->setStatusNotAllowed()
                    ->setError($e)
                    ->build()
                ;
            }
        }

        return $out($request, $response);
    }
}