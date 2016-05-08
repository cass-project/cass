<?php
namespace Application\EmailVerification\Middleware;

use Application\Auth\Service\CurrentAccountService;
use Application\Common\REST\GenericRESTResponseBuilder;
use Application\EmailVerification\Middleware\Command\Command;
use Application\EmailVerification\Service\EmailVerificationService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class EmailVerificationMiddleware implements MiddlewareInterface
{
    private $emailVerificationService;
    private $currentAccountService;

    public function __construct(EmailVerificationService $emailVerificationService, CurrentAccountService $currentAccountService)
    {
        $this->emailVerificationService = $emailVerificationService;
        $this->currentAccountService = $currentAccountService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);

            $command = Command::factory($request, $this->emailVerificationService, $this->currentAccountService);
            $result = $command->run($request);

            if ($result === true) {
                $result = [];
            }

            $responseBuilder
                ->setStatusSuccess()
                ->setJson($result);




        return $responseBuilder->build();
    }

}