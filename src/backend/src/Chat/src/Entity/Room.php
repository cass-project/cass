<?php

namespace CASS\Chat\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdTrait;
use CASS\Util\JSONSerializable;

class Room implements IdEntity, JSONSerializable
{
    use IdTrait;

    const OWNER_TYPE_PROFILE = 1;

    private $name;
    private $image;
    private $ownerId;
    private $ownerType;
    private $created;
    private $accessPrivilege;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getOwnerType()
    {
        return $this->ownerType;
    }

    public function setOwnerType($ownerType)
    {
        $this->ownerType = $ownerType;
    }

    public function getOwnerId()
    {
        return $this->ownerId;
    }

    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getAccessPrivilege()
    {
        return $this->accessPrivilege;
    }

    public function setAccessPrivilege($accessPrivilege)
    {
        $this->accessPrivilege = $accessPrivilege;
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'owner_id' => $this->ownerId,
            'owner_type' => $this->ownerType,
            'created' => $this->created,
            'access_privilege' => $this->accessPrivilege,
        ];
    }

}