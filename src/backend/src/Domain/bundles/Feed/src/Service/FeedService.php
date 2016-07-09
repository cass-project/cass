<?php
namespace Domain\Feed\Service;

use Domain\Feed\Source\Source;

final class FeedService
{
    /** @var \MongoDB */
    private $mongoDB;
    
    public function __construct(\MongoDB $mongoDB, array $sources)
    {
        $this->mongoDB = $mongoDB;
        $this->sources = $sources;
    }
    
    public function getCollection(Source $source): \MongoCollection
    {
        return $this->mongoDB->selectCollection($source->getMongoDBCollection());
    }
}