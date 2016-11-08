<?php
namespace ZEA2\Platform\Markers\OwnerEntity;

interface OwnerEntity
{
    public function hasOwner(): bool;
    public function setOwner(Owner $owner);
    public function getOwner(): Owner;
}