<?php
namespace Profile\Middleware;

use Application\REST\GenericRESTResponseBuilder;
use Profile\Middleware\Command\Command;
use Profile\Repository\ProfileRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProfileMiddleware implements MiddlewareInterface
{
    /** @var ProfileRepository */
    private $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function __invoke(Request $request, Response $response, callable $out = NULL)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);
        $command = Command::factory($request);
        $json = $command->run($request);
        return $responseBuilder
            ->setStatusSuccess()
            ->setJson($json)
            ->build()
        ;
    }
}