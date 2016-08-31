<?php
namespace Domain\ProfileCommunities\Middleware;

use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use CASS\Application\Service\CommandService;
use Domain\ProfileCommunities\Middleware\Command\JoinCommand;
use Domain\ProfileCommunities\Middleware\Command\LeaveCommand;
use Domain\ProfileCommunities\Middleware\Command\ListCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProfileCommunitiesMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    public function __construct(CommandService $commandService)
    {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null) {
        $responseBuilder = new GenericResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect('join', JoinCommand::class)
            ->attachDirect('leave', LeaveCommand::class)
            ->attachDirect('joined-communities', ListCommand::class)
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}