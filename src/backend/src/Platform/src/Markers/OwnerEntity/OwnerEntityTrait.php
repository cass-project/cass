<?php
namespace ZEA2\Platform\Markers\OwnerEntity;

trait OwnerEntityTrait
{
    /**
     * @Column(name="owner", type="json_array")
     * @var array
     */
    private $owner;

    public function hasOwner(): bool
    {
        return $this->owner !== null;
    }

    public function setOwner(Owner $owner)
    {
        $this->owner = $owner->toJSON();
    }

    public function getOwner(): Owner
    {
        $className = $this->owner['class'];
        $ownerType = $this->owner['type'];
        $ownerId = $this->owner['id'];

        // TODO:: PHPSTORM 7.1 ENABLE
        // ["class" => $className, "type" => $ownerType, "id" => $ownerId] = $this->owner;

        if(is_subclass_of($className, Owner::class)) {
            return new $className($ownerType, $ownerId);
        }else{
            throw new \Exception(sprintf('Invalid owner: class `%s` is not a subclass of `%s`', $className, Owner::class));
        }
    }
}