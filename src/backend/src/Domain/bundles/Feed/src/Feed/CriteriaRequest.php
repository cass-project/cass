<?php
namespace Domain\Feed\Feed;

use Domain\Feed\Feed\Criteria;

class CriteriaRequest
{
    /** @var \Domain\Feed\Feed\Criteria[] */
    private $criteria = [];

    public function addCriteria(\Domain\Feed\Feed\Criteria $criteria) {
        $criteriaClassName = get_class($criteria);

        if($this->hasCriteria($criteriaClassName)) {
            throw new \Exception(sprintf('Criteria with name `%s` already exists', $criteriaClassName));
        }

        $this->criteria[$criteriaClassName] =  $criteria;
    }

    public function hasCriteria(string $criteriaClassName) {
        return isset($this->criteria[$criteriaClassName])
            && ($this->criteria[$criteriaClassName] instanceof \Domain\Feed\Feed\Criteria);
    }

    public function gracefullyWith(string $criteriaClassName, Callable $callback) {
        if($this->hasCriteria($criteriaClassName)) {
            $callback($this->criteria[$criteriaClassName]);
        }
    }

    public function doWith(string $criteriaClassName, Callable $callback) {
        if(!$this->hasCriteria($criteriaClassName)) {
            throw new \Exception(sprintf('Criteria `%s` is not availabe', $criteriaClassName));
        }

        return $callback($this->criteria[$criteriaClassName]);
    }

    public function removeCriteria(string $criteriaClassName) {
        if(isset($this->criteria[$criteriaClassName])) {
            unset($this->criteria[$criteriaClassName]);
        }
    }

    public function getCriteria() {
        return $this->criteria;
    }
}