<?php
namespace Domain\ProfileCommunities\Middleware;

use Application\REST\Response\GenericResponseBuilder;
use Domain\ProfileCommunities\Middleware\Command\Command;
use Domain\ProfileCommunities\Service\ProfileCommunitiesService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProfileCommunitiesMiddleware implements MiddlewareInterface
{
    /** @var ProfileCommunitiesService */
    private $profileCommunitiesService;

    public function __construct(ProfileCommunitiesService $profileCommunitiesService) {
        $this->profileCommunitiesService = $profileCommunitiesService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null) {
        $responseBuilder = new GenericResponseBuilder($response);

        $command = Command::factory($request, $this->profileCommunitiesService);
        $result = $command($request);

        $responseBuilder
            ->setStatusSuccess()
            ->setJson($result);

        return $responseBuilder->build();
    }
}