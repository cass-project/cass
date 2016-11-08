<?php
namespace ZEA2\Platform\Markers\OwnerEntity;

use ZEA2\Platform\Markers\JSONSerializable;

class Owner implements JSONSerializable
{
    /** @var string */
    private $ownerType;

    /** @var string */
    private $ownerId;

    public final function __construct(string $ownerType, string $ownerId)
    {
        $this->validateOwner($ownerType, $ownerId);
    }

    public function toJSON(): array
    {
        return [
            'class' => static::class,
            'type' => $this->getOwnerType(),
            'id' => $this->getOwnerId(),
        ];
    }

    protected function validateOwner(string $ownerType, string $ownerId): bool
    {
        return true;
    }

    public final function getOwnerType(): string
    {
        return $this->ownerType;
    }

    public final function getOwnerId(): string
    {
        return $this->ownerId;
    }
}