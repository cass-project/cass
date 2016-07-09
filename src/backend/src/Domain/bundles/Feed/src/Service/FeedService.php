<?php
namespace Domain\Feed\Service;

use Domain\Feed\Source\Source;
use MongoDB\Collection;
use MongoDB\Database;

final class FeedService
{
    /** @var Database */
    private $mongoDB;
    
    public function __construct(Database $mongoDB)
    {
        $this->mongoDB = $mongoDB;
    }
    
    public function getCollection(Source $source): Collection
    {
        return $this->mongoDB->selectCollection($source->getMongoDBCollection());
    }
}