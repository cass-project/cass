<?php
namespace Domain\Community\Middleware;

use Application\REST\Response\GenericResponseBuilder;
use Domain\Community\Middleware\Command\Command;
use Domain\Community\Service\CommunityService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

final class CommunityMiddleware implements MiddlewareInterface
{
    /** @var CommunityService */
    private $communityService;

    public function __construct(CommunityService $communityService)
    {
        $this->communityService = $communityService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericResponseBuilder($response);

        $command = Command::factory($request, $this->communityService);
        $result = $command->run($request);

        $responseBuilder
            ->setStatusSuccess()
            ->setJson($result);

        return $responseBuilder->build();
    }
}