<?php
namespace Auth\Middleware;

use Auth\Service\AuthService;
use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class HeadersMiddleware implements MiddlewareInterface
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
        try {
            $this->authService->attemptSignIn($request);
            $response = $response->withAddedHeader('Authenticatied', 'true');
        } catch (InvalidCredentialsException $e) {
            // Response without header
        }

        return $out($request, $response);
    }
}