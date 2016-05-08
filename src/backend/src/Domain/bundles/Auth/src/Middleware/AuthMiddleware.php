<?php
namespace Domain\Auth\Middleware;

use Application\Common\REST\GenericRESTResponseBuilder;
use Domain\Auth\Middleware\Command\Command;
use Domain\Auth\Service\AuthService;
use Application\Frontline\Service\FrontlineService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    /** @var AuthService */
    private $authService;

    /** @var FrontlineService */
    private $frontlineService;

    public function __construct(AuthService $authService, FrontlineService $frontlineService)
    {
        $this->authService = $authService;
        $this->frontlineService = $frontlineService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);

        $command = Command::factory($request, $this->authService);
        $command->setAuthService($this->authService);
        $command->setFrontlineService($this->frontlineService);
        $command->run($request, $responseBuilder);

        return $responseBuilder->build();
    }

}