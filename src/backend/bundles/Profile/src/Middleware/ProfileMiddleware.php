<?php
namespace Profile\Middleware;

use Auth\Service\CurrentAccountService;
use Common\REST\GenericRESTResponseBuilder;
use Profile\Exception\UnknownGreetingsException;
use Profile\Middleware\Command\Command;
use Profile\Service\ProfileService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProfileMiddleware implements MiddlewareInterface
{
    /** @var ProfileService */
    private $profileService;

    /** @var CurrentAccountService */
    private $currentAccountService;

    public function __construct(ProfileService $profileService, CurrentAccountService $currentAccountService)
    {
        $this->profileService = $profileService;
        $this->currentAccountService = $currentAccountService;
    }

    public function __invoke(Request $request, Response $response, callable $out = NULL)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);

        try {
            $command = Command::factory($request, $this->profileService, $this->currentAccountService);
            $result = $command->run($request);

            if($result === true) {
                $result = [];
            }

            $responseBuilder
                ->setStatusSuccess()
                ->setJson($result);
        }catch(UnknownGreetingsException $e) {
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e)
            ;
        }

        return $responseBuilder->build();
    }
}