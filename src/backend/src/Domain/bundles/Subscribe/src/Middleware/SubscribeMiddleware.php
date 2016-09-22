<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware;

use CASS\Application\REST\CASSResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Domain\Bundles\Subscribe\Middleware\Command\ListSubscribedCollectionsCommand;
use CASS\Domain\Bundles\Subscribe\Middleware\Command\ListSubscribedCommunitiesCommand;
use CASS\Domain\Bundles\Subscribe\Middleware\Command\ListSubscribedProfilesCommand;
use CASS\Domain\Bundles\Subscribe\Middleware\Command\ListSubscribedThemesCommand;
use CASS\Domain\Bundles\Subscribe\Middleware\Command\SubscribeCollectionCommand;
use CASS\Domain\Bundles\Subscribe\Middleware\Command\SubscribeCommunityCommand;
use CASS\Domain\Bundles\Subscribe\Middleware\Command\SubscribeProfileCommand;
use CASS\Domain\Bundles\Subscribe\Middleware\Command\SubscribeThemeCommand;
use CASS\Domain\Bundles\Subscribe\Middleware\Command\UnSubscribeCollectionCommand;
use CASS\Domain\Bundles\Subscribe\Middleware\Command\UnSubscribeCommunityCommand;
use CASS\Domain\Bundles\Subscribe\Middleware\Command\UnSubscribeProfileCommand;
use CASS\Domain\Bundles\Subscribe\Middleware\Command\UnSubscribeThemeCommand;
use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SubscribeMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    public function __construct(CommandService $commandService) {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = NULL)
    {
        $responseBuilder = new CASSResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect("subscribe-theme", SubscribeThemeCommand::class, 'PUT')
            ->attachDirect("unsubscribe-theme", UnSubscribeThemeCommand::class, 'DELETE')
            ->attachDirect("list-themes", ListSubscribedThemesCommand::class, 'POST')
            ->attachDirect("subscribe-profile", SubscribeProfileCommand::class, 'PUT')
            ->attachDirect("unsubscribe-profile", UnSubscribeProfileCommand::class, 'DELETE')
            ->attachDirect("list-profiles", ListSubscribedProfilesCommand::class, 'POST')
            ->attachDirect("subscribe-collection", SubscribeCollectionCommand::class, 'PUT')
            ->attachDirect("unsubscribe-collection", UnSubscribeCollectionCommand::class, 'DELETE')
            ->attachDirect("list-collections", ListSubscribedCollectionsCommand::class, 'POST')
            ->attachDirect("subscribe-community", SubscribeCommunityCommand::class, 'PUT')
            ->attachDirect("unsubscribe-community", UnSubscribeCommunityCommand::class, 'DELETE')
            ->attachDirect("list-communities", ListSubscribedCommunitiesCommand::class, 'POST')
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}