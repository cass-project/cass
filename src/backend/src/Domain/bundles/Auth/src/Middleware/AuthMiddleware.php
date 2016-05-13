<?php
namespace Domain\Auth\Middleware;

use Application\REST\Response\GenericResponseBuilder;
use Domain\Auth\Middleware\Command\Command;
use Domain\Auth\Service\AuthService;
use Application\Frontline\Service\FrontlineService;
use Domain\Auth\Service\AuthService\Exceptions\DuplicateAccountException;
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
        $responseBuilder = new GenericResponseBuilder($response);

        try {
            $command = Command::factory($request, $this->authService);
            $command->setAuthService($this->authService);
            $command->setFrontlineService($this->frontlineService);

            $command->run($request, $responseBuilder);
        }catch(DuplicateAccountException $e) {
            $responseBuilder
                ->setStatusDuplicate()
                ->setError($e);
        }

        return $responseBuilder->build();
    }

}