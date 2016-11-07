<?php
namespace CASS\Domain\Bundles\Profile\Entity\Card\Values;

use CASS\Domain\Bundles\Profile\Exception\MaxCardEntitiesLimitException;

final class ProfileCardValuesManager
{
    const MAX_ENTITIES_LIMIT = 100;

    /** @var ProfileCardValue[] */
    private $values = [];
    
    public function __construct(array $values)
    {
        if(count($values) > self::MAX_ENTITIES_LIMIT) {
            throw new MaxCardEntitiesLimitException(sprintf('ProfileCard can store only `%d` entities, got `%d`', self::MAX_ENTITIES_LIMIT, count($values)));
        }

        array_map(function(ProfileCardValue $value) {
            $this->values[$value->getKey()] = $value;
        }, $values);
    }

    public function hasValue(string $key): bool
    {
        return isset($this->values[$key]);
    }

    public function deleteValue(string $key): self
    {
        if(isset($this->values[$key])) {
            unset($this->values[$key]);
        }

        return $this;
    }

    public function getValue(string $key): ProfileCardValue
    {
        if(! isset($this->values[$key])) {
            throw new \Exception(sprintf('Values with key `%s` not found'));
        }

        return $this->values[$key];
    }

    public function setValue(string $key, $value): self
    {
        if($this->hasValue($key)) {
            $this->values[$key]->setValue($value);
        }else{
            if(count($this->values) >= self::MAX_ENTITIES_LIMIT) {
                throw new MaxCardEntitiesLimitException(sprintf('ProfileCard can store only `%d` entities', self::MAX_ENTITIES_LIMIT));
            }

            $this->values[$key] = new ProfileCardValue($key, $value);
        }

        return $this;
    }

    public function getAll(): array
    {
        return $this->values;
    }
}