<?php
namespace EmailVerification\Middleware;

use Common\REST\GenericRESTResponseBuilder;
use EmailVerification\Middleware\Command\Command;
use EmailVerification\Service\EmailVerificationService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class EmailVerificationMiddleware implements MiddlewareInterface
{
    private $emailVerificationService;

    public function __construct(EmailVerificationService $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);

        try {
            $command = Command::factory($request, $this->emailVerificationService);
            $result = $command->run($request);

            if ($result === true) {
                $result = [];
            }

            $responseBuilder
                ->setStatusSuccess()
                ->setJson($result);

        } catch (\Exception $e) {
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e);
        }



        return $responseBuilder->build();
    }

}