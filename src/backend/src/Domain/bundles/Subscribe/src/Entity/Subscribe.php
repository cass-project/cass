<?php
namespace CASS\Domain\Bundles\Subscribe\Entity;

/**
 * @Entity(repositoryClass="CASS\Domain\Bundles\Subscribe\Repository\SubscribeRepository")
 * @Table(name="subscribe")
 */
class Subscribe
{
    const TYPE_THEME = 1;
    const TYPE_PROFILE = 2;
    const TYPE_COLLECTION = 3;
    const TYPE_COMMUNITY = 4;

    private $profileId;
    private $subscribeId;
    private $subscribeType;

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
}