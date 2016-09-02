<?php
namespace CASS\Domain\Feed\Search\Stream;

use CASS\Domain\Feed\Search\Criteria\CriteriaManager;

use CASS\Domain\Index\Source\Source;
use MongoDB\Collection;
use MongoDB\Model\BSONDocument;

abstract class Stream
{
    const DEFAULT_LIMIT = 100;
    
    /** @var Source */
    protected $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    abstract public function fetch(CriteriaManager $criteriaManager, Collection $collection): array;

    protected function cleanResults(array $results)
    {
        return array_filter($results, function($input) {
            return $input !== null;
        });
    }
}