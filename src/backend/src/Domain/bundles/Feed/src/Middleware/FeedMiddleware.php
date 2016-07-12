<?php
namespace Domain\Feed\Middleware;

use Application\REST\Response\GenericResponseBuilder;
use Application\Service\CommandService;
use Domain\Feed\Exception\AbstractFeedException;
use Domain\Feed\Middleware\Command\CollectionCommand;
use Domain\Feed\Middleware\Command\ProfileCommand;
use Domain\Feed\Middleware\Command\PublicContentCommand;
use Domain\Feed\Middleware\Command\PublicExpertsCommand;
use Domain\Feed\Middleware\Command\PublicProfilesCommand;
use Domain\Feed\Source\PublicCatalog\PublicCollectionsSource;
use Domain\Feed\Source\PublicCatalog\PublicCommunitiesSource;
use Domain\Feed\Source\PublicCatalog\PublicDiscussionsSource;
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
                ->attachDirect('public-profiles', PublicProfilesCommand::class)
                ->attachDirect('public-experts', PublicExpertsCommand::class)
                ->attachDirect('public-content', PublicContentCommand::class)
                ->attachDirect('public-discussions', PublicDiscussionsSource::class)
                ->attachDirect('public-communities', PublicCommunitiesSource::class)
                ->attachDirect('public-collections', PublicCollectionsSource::class)
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