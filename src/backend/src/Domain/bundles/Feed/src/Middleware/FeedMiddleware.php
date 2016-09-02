<?php
namespace CASS\Domain\Bundles\Feed\Middleware;

use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Domain\Bundles\Feed\Exception\AbstractFeedException;
use CASS\Domain\Bundles\Feed\Middleware\Command\CollectionCommand;
use CASS\Domain\Bundles\Feed\Middleware\Command\CommunityCommand;
use CASS\Domain\Bundles\Feed\Middleware\Command\ProfileCommand;
use CASS\Domain\Bundles\Feed\Middleware\Command\PublicCommunitiesCommand;
use CASS\Domain\Bundles\Feed\Middleware\Command\PublicContentCommand;
use CASS\Domain\Bundles\Feed\Middleware\Command\PublicExpertsCommand;
use CASS\Domain\Bundles\Feed\Middleware\Command\PublicProfilesCommand;
use CASS\Domain\Bundles\Feed\Middleware\Command\PublicDiscussionsCommand;
use CASS\Domain\Bundles\Feed\Middleware\Command\PublicCollectionsCommand;
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