<?php

namespace CASS\Domain\Bundles\Like\Middleware;

use CASS\Application\REST\CASSResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Domain\Bundles\Like\Middleware\Command\PostCommand\AddLikePostCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class LikePostMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    public function __construct(CommandService $commandService)
    {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new CASSResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect('add-like', AddLikePostCommand::class, 'PUT')
//            ->attachDirect('add-dislike', AddDisLikeCommunityCommand::class, 'PUT')
//            ->attachDirect('remove-attitude', RemoveCommunityAttitudeCommunityCommand::class, 'DELETE')
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}