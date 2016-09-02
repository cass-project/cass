<?php
namespace CASS\Domain\Feed\Search\Criteria;

use CASS\Domain\Feed\Exception\CriteriaAlreadyExistsException;
use CASS\Domain\Feed\Exception\CriteriaNotFoundException;

final class CriteriaManager
{
    /** @var Criteria[] */
    private $criteria = [];
    
    public function attachCriteria(Criteria $criteria): self
    {
        $criteriaClassName = get_class($criteria);

        if(isset($this->criteria[$criteriaClassName])) {
            throw new CriteriaAlreadyExistsException(sprintf('Criteria `%s` already exists', $criteriaClassName));
        }

        $this->criteria[$criteriaClassName] = $criteria;

        return $this;
    }

    public function detachCriteria(string $criteriaClassName, bool $silent = false): self
    {
        if(! $this->hasCriteria($criteriaClassName)) {
            if($silent) {
                return $this;
            }else{
                throw new CriteriaNotFoundException(sprintf('Criteria `%s` not found', $criteriaClassName));
            }
        }

        unset($this->criteria[$criteriaClassName]);

        return $this;
    }

    public function hasCriteria(string $criteriaClassName): bool
    {
        return isset($this->criteria[$criteriaClassName]);
    }

    public function doWith(string $criteriaClassName, Callable $callback): self
    {
        if($this->hasCriteria($criteriaClassName)) {
            $callback($this->criteria[$criteriaClassName]);
        }

        return $this;
    }

    public function requireWith(string $criteriaClassName, Callable $callback): self
    {
        if(! $this->hasCriteria($criteriaClassName)) {
            throw new CriteriaNotFoundException(sprintf('Criteria `%s` is required but not found', $criteriaClassName));
        }

        return $this->doWith($criteriaClassName, $callback);
    }
}