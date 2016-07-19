<?php
namespace Domain\Feed\Service;

use Application\Exception\NotImplementedException;
use Domain\Feed\Request\FeedRequest;
use Domain\Feed\Search\Stream\StreamFactory;
use Domain\Index\Source\Source;
use MongoDB\BSON\ObjectID;
use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\Model\BSONDocument;

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