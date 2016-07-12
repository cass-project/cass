<?php
namespace Domain\Feed\Search\Stream;

use Domain\Feed\Search\Criteria\CriteriaManager;
use Domain\Feed\Service\Entity;
use Domain\Feed\Source\Source;
use MongoDB\Collection;
use MongoDB\Model\BSONDocument;

abstract class Stream
{
    /** @var Source */
    protected $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    /**
     * @param CriteriaManager $criteriaManager
     * @param Collection $collection
     * @return BSONDocument[]
     */
    abstract public function fetch(CriteriaManager $criteriaManager, Collection $collection): array;
}