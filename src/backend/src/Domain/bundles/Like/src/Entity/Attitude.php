<?php

namespace CASS\Domain\Bundles\Like\Entity;

use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use CASS\Util\JSONSerializable;
use ZEA2\Platform\Markers\IdEntity\IdEntity;
use ZEA2\Platform\Markers\IdEntity\IdEntityTrait;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

/**
 * @Entity(repositoryClass="CASS\Domain\Bundles\Like\Repository\LikeRepository\LikeRepository")
 * @Table(name="like_attitude_log")
 */
class Attitude implements IdEntity, JSONSerializable
{
    use IdEntityTrait;

    const ATTITUDE_OWNER_TYPE_ANONYMOUS = 1;
    const ATTITUDE_OWNER_TYPE_PROFILE = 2;

    const ATTITUDE_TYPE_LIKE = 1;
    const ATTITUDE_TYPE_DISLIKE = 2;

    const RESOURCE_TYPE_PROFILE = 1;
    const RESOURCE_TYPE_THEME = 2;
    const RESOURCE_TYPE_COLLECTION = 3;
    const RESOURCE_TYPE_COMMUNITY = 4;
    const RESOURCE_TYPE_POST = 5;

    /**
     * @Column(type="integer", name="owner_type")
     * @var int
     */
    protected $attitudeOwnerType;

    /**
     * @Column(type="integer", name="profile_id")
     * @var int
     */
    protected $profileId;

    /**
     * @Column(type="string", name="ip_address")
     * @var string
     */
    protected $ipAddress;

    /**
     * @Column(type="integer", name="attitude_type")
     * @var int
     */
    protected $attitudeType;

    /**
     * @Column(type="integer", name="resource_id")
     * @var int
     */
    protected $resourceId;
    /**
     * @Column(type="integer", name="resource_type")
     * @var int
     */
    protected $resourceType;

    /**
     * @Column(type="datetime", name="created")
     * @var \DateTime
     */
    protected $created;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    public function getAttitudeType(): int
    {
        return $this->attitudeType;
    }

    public function getAttitudeOwnerType(): int
    {
        return $this->attitudeOwnerType;
    }

    public function setAttitudeOwnerType(int $attitudeOwnerType): self
    {
        $this->attitudeOwnerType = $attitudeOwnerType;

        return $this;
    }

    public function setAttitudeType(int $attitudeType): self
    {
        $this->attitudeType = $attitudeType;

        return $this;
    }

    public function getProfileId()
    {
        return $this->profileId;
    }

    public function setProfileId(int $profileId): self
    {
        $this->profileId = $profileId;

        return $this;
    }

    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getResourceId(): int
    {
        return $this->resourceId;
    }

    protected function setResourceId(int $resourceId): self
    {
        $this->resourceId = $resourceId;

        return $this;
    }

    public function getResourceType(): int
    {
        return $this->resourceType;
    }

    protected function setResourceType(int $resourceType): self
    {
        $this->resourceType = $resourceType;

        return $this;
    }


    public function setResource(LikeableEntity $entity): self
    {
        switch(get_class($entity)){
            case Profile::class :{
                /** @var Profile $entity */
                $this->setResourceId($entity->getId())->setResourceType(self::RESOURCE_TYPE_PROFILE);
                break;
            }
            case Theme::class :{
                /** @var Theme $entity */
                $this->setResourceId($entity->getId())->setResourceType(self::RESOURCE_TYPE_THEME);
                break;
            }
            case Community::class :{
                /** @var Community $entity */
                $this->setResourceId($entity->getId())->setResourceType(self::RESOURCE_TYPE_COMMUNITY);
                break;
            }
            case Collection::class :{
                /** @var Collection $entity */
                $this->setResourceId($entity->getId())->setResourceType(self::RESOURCE_TYPE_COLLECTION);
                break;
            }
            case Post::class :{
                /** @var Post $entity */
                $this->setResourceId($entity->getId())->setResourceType(self::RESOURCE_TYPE_POST);
                break;
            }
        }

        return $this;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->getId(),
            'attitude_type' => $this->getAttitudeType(),
            'profile_id' => $this->getProfileId(),
            'ip_address' => $this->getIpAddress(),
            'resource_id' => $this->getResourceId(),
            'resource_type' => $this->getResourceType(),
        ];
    }
}