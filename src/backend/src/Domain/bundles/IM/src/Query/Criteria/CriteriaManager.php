<?php
namespace CASS\Domain\Bundles\IM\Query\Criteria;

use CASS\Domain\Bundles\IM\Exception\Query\DuplicateCriteriaException;
use CASS\Domain\Bundles\IM\Exception\Query\UnknownCriteriaException;

final class CriteriaManager
{
    /** @var Criteria[] */
    private $criteria = [];

    public function __construct(array $criteria)
    {
        array_map(function(Criteria $criteria) {
            $key = get_class($criteria);
            
            if(isset($this->criteria[$key])) {
                throw new DuplicateCriteriaException(sprintf('Criteria `%s` is duplicated', $key));
            }
            
            $this->criteria[$key] = $criteria;
        }, $criteria);
    }

    public function getCriteria(string $criteriaClassName): Criteria
    {
        if(! $this->hasCriteria($criteriaClassName)) {
            throw new UnknownCriteriaException(sprintf('Criteria `%s` not found', $criteriaClassName));
        }

        return $this->criteria[$criteriaClassName];
    }

    public function hasCriteria(string $criteriaClassName): bool
    {
        return isset($this->criteria[$criteriaClassName]);
    }

    public function doWith(string $criteriaClassName, Callable $callback)
    {
        if($this->hasCriteria($criteriaClassName)) {
            $callback($this->getCriteria($criteriaClassName));
        }
    }

    public function requireWith(string $criteriaClassName, Callable $callback)
    {
        if($this->hasCriteria($criteriaClassName)) {
            $callback($this->getCriteria($criteriaClassName));
        }else{
            throw new UnknownCriteriaException(sprintf('Criteria `%s` is required but not found', $criteriaClassName));
        }
    }
}