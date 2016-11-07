<?php
namespace CASS\Domain\Bundles\Subscribe\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdEntityTrait;

/**
 * @Entity(repositoryClass="CASS\Domain\Bundles\Subscribe\Repository\SubscribeRepository")
 * @Table(name="subscribe")
 */
class Subscribe implements IdEntity
{
    const TYPE_THEME = 1;
    const TYPE_PROFILE = 2;
    const TYPE_COLLECTION = 3;
    const TYPE_COMMUNITY = 4;

    use IdEntityTrait;

    /**
     * @Column(type="integer", name="profile_id")
     * @var int
     */
    private $profileId;

    /**
     * @var int
     * @Column(type="integer", name="subscribe_id")
     */
    private $subscribeId;

    /**
     * @var int
     * @Column(type="integer", name="type")
     */
    private $subscribeType;

    /**
     * @var string
     * @Column(type="text", name="options")
     */
    private $options;

    public function getProfileId()
    {
        return $this->profileId;
    }

    public function setProfileId(int $profileId):self
    {
        $this->profileId = $profileId;
        return $this;
    }

    public function getSubscribeId()
    {
        return $this->subscribeId;
    }

    public function setSubscribeId(int $subscribeId):self
    {
        $this->subscribeId = $subscribeId;
        return $this;
    }

    public function getSubscribeType()
    {
        return $this->subscribeType;
    }

    public function setSubscribeType(int $subscribeType):self
    {
        $this->subscribeType = $subscribeType;
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options):self
    {
        $this->options = $options;
        return $this;
    }

    public function toJSON(): array
    {
        return [
            'profileId'     => $this->profileId,
            'subscribeId'   => $this->subscribeId,
            'subscribeType' => $this->subscribeType
        ];
    }
}