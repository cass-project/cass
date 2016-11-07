<?php
namespace CASS\Domain\Bundles\Profile\Entity\Card\Access;

use CASS\Domain\Bundles\Profile\Exception\MaxCardEntitiesLimitException;

final class ProfileCardAccessManager
{
    const MAX_ENTITIES_LIMIT = 100;

    /** @var ProfileCardAccess[] */
    private $access = [];

    public function __construct(array $access)
    {
        if(count($access) > self::MAX_ENTITIES_LIMIT) {
            throw new MaxCardEntitiesLimitException(sprintf('ProfileCard can store only `%d` entities, got `%d`', self::MAX_ENTITIES_LIMIT, count($access)));
        }

        array_map(function(ProfileCardAccess $access) {
            $this->access[$access->getKey()] = $access;
        }, $access);
    }

    public function hasAccessConfig(string $key): bool
    {
        return isset($this->access[$key]);
    }

    public function getAccess(string $key): ProfileCardAccess
    {
        if(! isset($this->access[$key])) {
            throw new \Exception(sprintf('Access with key `%s` not found'));
        }

        return $this->access[$key];
    }

    public function setAccess(string $key, string $level): self
    {
        if($this->hasAccessConfig($key)) {
            $this->access[$key]->setAccessLevel($level);
        }else{
            if(count($this->access) >= self::MAX_ENTITIES_LIMIT) {
                throw new MaxCardEntitiesLimitException(sprintf('ProfileCard can store only `%d` entities', self::MAX_ENTITIES_LIMIT));
            }

            $this->access[$key] = new ProfileCardAccess($key, $level);
        }

        return $this;
    }

    public function getAll(): array
    {
        return $this->access;
    }
}