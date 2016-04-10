<?php
namespace Auth\Middleware;

use Common\REST\GenericRESTResponseBuilder;
use Common\REST\Exceptions\UnknownActionException;
use Auth\Middleware\Command\Command;
use Auth\Service\AuthService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);

        try {
            $command = Command::factory($request, $this->authService);
            $command->setAuthService($this->authService);
            $command->run($request, $responseBuilder);
        }catch (UnknownActionException $e) {
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e)
            ;
        }

        return $responseBuilder->build();
    }

}