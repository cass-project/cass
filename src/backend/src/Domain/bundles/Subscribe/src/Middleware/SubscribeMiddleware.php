<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware;

use CASS\Application\Service\CommandService;
use CASS\Domain\Bundles\Subscribe\Middleware\Command\ListSubscribedCollectionsCommand;
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
use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
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
        $responseBuilder = new GenericResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect("theme-subscribe", SubscribeThemeCommand::class, 'GET')
            ->attachDirect("unsubscribe-theme", UnSubscribeThemeCommand::class, 'GET')
            ->attachDirect("list-themes", ListSubscribedThemesCommand::class, 'GET')
            ->attachDirect("subscribe-profile", SubscribeProfileCommand::class, 'GET')
            ->attachDirect("unsubscribe-profile", UnSubscribeProfileCommand::class, 'GET')
            ->attachDirect("list-profiles", ListSubscribedProfilesCommand::class, 'GET')
            ->attachDirect("subscribe-collection", SubscribeCollectionCommand::class, 'GET')
            ->attachDirect("unsubscribe-collection", UnSubscribeCollectionCommand::class, 'GET')
            ->attachDirect("list-collections", ListSubscribedCollectionsCommand::class, 'GET')
            ->attachDirect("subscribe-community", SubscribeCommunityCommand::class, 'GET')
            ->attachDirect("unsubscribe-community", UnSubscribeCommunityCommand::class, 'GET')
            ->attachDirect("list-communities", UnSubscribeCommunityCommand::class, 'GET')
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}