<?php
namespace Auth\Middleware;

use Application\REST\GenericRESTResponseBuilder;
use Application\REST\UnknownActionException;
use Auth\Service\AuthService;
use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * AuthMiddleware constructor.
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);

        try {
            $action = $request->getAttribute('action');

            switch($action) {
                default:
                    throw new UnknownActionException(sprintf('Unknown exception `%s`', $action));

                case 'sign-in':
                    $this->signIn($request, $responseBuilder);
                    break;

                case 'logout':
                    $this->logOut($request, $responseBuilder);
                    break;

            }
        }catch (UnknownActionException $e) {
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e)
            ;
        }

        return $responseBuilder->build();
    }

    private function signIn(Request $request, GenericRESTResponseBuilder $responseBuilder)
    {
        try {
            $qp = $request->getQueryParams();
            $login = $qp['login'];
            $password = $qp['password'];

            $this->authService->attemptSignIn($login, $password);

            $responseBuilder->setStatusSuccess();
        }catch(InvalidCredentialsException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e)
            ;
        }
    }

    private function logOut(Request $request, GenericRESTResponseBuilder $responseBuilder)
    {

    }
}