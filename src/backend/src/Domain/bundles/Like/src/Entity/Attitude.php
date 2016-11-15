<?php

namespace Domain\bundles\Like\src\Entity;

use CASS\Util\JSONSerializable;
use ZEA2\Platform\Markers\IdEntity\IdEntity;
use ZEA2\Platform\Markers\IdEntity\IdEntityTrait;

class Attitude implements IdEntity, JSONSerializable
{
    use IdEntityTrait;

    const ATTITUDE_TYPE_LIKE = 1;
    const ATTITUDE_TYPE_DISLIKE = 2;

    const RESOURCE_TYPE_PROFILE = 1;
    const RESOURCE_TYPE_THEME = 2;
    const RESOURCE_TYPE_COLLECTION = 3;
    const RESOURCE_TYPE_COMMUNITY = 4;

    protected $attitudeType;
    protected $profileId;
    protected $ipAddress;
    protected $resourceId;
    protected $resourceType;

    public function getAttitudeType(): int
    {
        return $this->attitudeType;
    }


    public function setAttitudeType(int $attitudeType): self
    {
        $this->attitudeType = $attitudeType;
        return $this;
    }


    public function getProfileId(): int
    {
        return $this->profileId;
    }


    public function setProfileId(int $profileId): self
    {
        $this->profileId = $profileId;
    }


    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }


    public function setIpAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;
    }


    public function getResourceId(): int
    {
        return $this->resourceId;
    }


    public function setResourceId(int $resourceId): self
    {
        $this->resourceId = $resourceId;
    }


    public function getResourceType(): int
    {
        return $this->resourceType;
    }


    public function setResourceType(int $resourceType): self
    {
        $this->resourceType = $resourceType;
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->getId(),
            'attitude_type' => $this->getAttitudeType(),
            'profile_id' => $this->getProfileId(),
            'ip_address' => $this->getIpAddress(),
            'resource_id' => $this->getResourceId(),
            'resource_type' => $this->getResourceType()
        ];
    }
}