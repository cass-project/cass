<?php
namespace Domain\Feed\Middleware;

use CASS\Application\REST\Response\GenericResponseBuilder;
use CASS\Application\Service\CommandService;
use Domain\Feed\Exception\AbstractFeedException;
use Domain\Feed\Middleware\Command\CollectionCommand;
use Domain\Feed\Middleware\Command\CommunityCommand;
use Domain\Feed\Middleware\Command\ProfileCommand;
use Domain\Feed\Middleware\Command\PublicCommunitiesCommand;
use Domain\Feed\Middleware\Command\PublicContentCommand;
use Domain\Feed\Middleware\Command\PublicExpertsCommand;
use Domain\Feed\Middleware\Command\PublicProfilesCommand;
use Domain\Feed\Middleware\Command\PublicDiscussionsCommand;
use Domain\Feed\Middleware\Command\PublicCollectionsCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

final class FeedMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    public function __construct(CommandService $commandService)
    {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null): ResponseInterface
    {
        $responseBuilder = new GenericResponseBuilder($response);

        try {
            $resolver = $this->commandService->createResolverBuilder()
                ->attachDirect('profile', ProfileCommand::class)
                ->attachDirect('collection', CollectionCommand::class)
                ->attachDirect('community', CommunityCommand::class)
                ->attachDirect('public-profiles', PublicProfilesCommand::class)
                ->attachDirect('public-experts', PublicExpertsCommand::class)
                ->attachDirect('public-content', PublicContentCommand::class)
                ->attachDirect('public-discussions', PublicDiscussionsCommand::class)
                ->attachDirect('public-communities', PublicCommunitiesCommand::class)
                ->attachDirect('public-collections', PublicCollectionsCommand::class)
                ->resolve($request)
            ;

            return $resolver->run($request, $responseBuilder);
        }catch(AbstractFeedException $e) {
            return $responseBuilder
                ->setError($e)
                ->setStatusBadRequest()
                ->build();
        }
    }
}