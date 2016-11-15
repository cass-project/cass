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

    public function toJSON(): array
    {
        // TODO: Implement toJSON() method.
    }
}