<?php
namespace CASS\Domain\Bundles\Feed\Middleware\Command;

use CASS\Application\Command\Command;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Feed\Factory\FeedSourceFactory;
use CASS\Domain\Bundles\Feed\Middleware\Request\FeedMiddlewareRequest;
use CASS\Domain\Bundles\Feed\Request\FeedRequest;
use CASS\Domain\Bundles\Feed\Search\Criteria\CriteriaFactory;
use CASS\Domain\Bundles\Feed\Service\FeedService;
use CASS\Domain\Bundles\Index\Source\Source;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractCommand implements Command
{
    /** @var FeedService */
    protected $feedService;
    
    /** @var FeedSourceFactory */
    protected $sourceFactory;

    /** @var CriteriaFactory */
    protected $criteriaFactory;

    public function __construct(
        FeedService $feedService,
        FeedSourceFactory $sourceFactory,
        CriteriaFactory $criteriaFactory
    ) {
        $this->feedService = $feedService;
        $this->sourceFactory = $sourceFactory;
        $this->criteriaFactory = $criteriaFactory;
    }

    protected function createFeedRequest(ServerRequestInterface $request): FeedRequest
    {
        return FeedRequest::createFromJSON($this->criteriaFactory, (new FeedMiddlewareRequest($request))->getParameters()['criteria']);
    }

    protected function makeFeed(Source $source, ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $request = $this->createFeedRequest($request);
        $entities = $this->feedService->getFeed($source, $request);

        $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'entities' => $entities
            ]);

        return $responseBuilder->build();
    }
}