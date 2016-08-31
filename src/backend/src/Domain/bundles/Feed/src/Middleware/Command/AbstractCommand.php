<?php
namespace Domain\Feed\Middleware\Command;

use CASS\Application\REST\Response\ResponseBuilder;
use Domain\Feed\Factory\FeedSourceFactory;
use Domain\Feed\Middleware\Request\FeedMiddlewareRequest;
use Domain\Feed\Request\FeedRequest;
use Domain\Feed\Search\Criteria\CriteriaFactory;
use Domain\Feed\Service\FeedService;
use Domain\Index\Source\Source;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractCommand implements \CASS\Application\Command\Command
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