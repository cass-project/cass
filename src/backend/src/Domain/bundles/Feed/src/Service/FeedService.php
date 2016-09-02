<?php
namespace CASS\Domain\Bundles\Feed\Service;


use CASS\Domain\Bundles\Feed\Request\FeedRequest;
use CASS\Domain\Bundles\Feed\Search\Stream\StreamFactory;
use CASS\Domain\Bundles\Index\Source\Source;

use MongoDB\Collection;
use MongoDB\Database;

final class FeedService
{
    /** @var Database */
    private $mongoDB;
    
    /** @var StreamFactory */
    private $streamFactory;

    public function __construct(Database $mongoDB, StreamFactory $streamFactory)
    {
        $this->mongoDB = $mongoDB;
        $this->streamFactory = $streamFactory;
    }

    public function getCollection(Source $source): Collection
    {
        return $this->mongoDB->selectCollection($source->getMongoDBCollection());
    }
    
    public function getFeed(Source $source, FeedRequest $feedRequest): array 
    {
        $collection = $this->mongoDB->selectCollection($source->getMongoDBCollection());
        $source->ensureIndexes($this->mongoDB, $collection);
        $stream = $this->streamFactory->getStreamForSource($source);

        return $stream->fetch($feedRequest->getCriteria(), $collection);
    }
}