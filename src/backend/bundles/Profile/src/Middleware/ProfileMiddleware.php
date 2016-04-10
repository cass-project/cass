<?php
namespace Profile\Middleware;

use Common\REST\GenericRESTResponseBuilder;
use Profile\Middleware\Command\Command;
use Profile\Service\ProfileService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProfileMiddleware implements MiddlewareInterface
{
    /** @var ProfileService */
    private $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function __invoke(Request $request, Response $response, callable $out = NULL)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);
        $command = Command::factory($request, $this->profileService);
        $result = $command->run($request);

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson($result)
        ->build();
    }
}