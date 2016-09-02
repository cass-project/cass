<?php
namespace CASS\Domain\ProfileCommunities\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdTrait;
use CASS\Util\JSONSerializable;
use CASS\Domain\Community\Entity\Community;
use CASS\Domain\Profile\Entity\Profile;
use CASS\Domain\Profile\Entity\Profile\Greetings;

/**
 * @Entity(repositoryClass="CASS\Domain\ProfileCommunities\Repository\ProfileCommunitiesRepository")
 * @Table(name="profile_communities")
 */
class ProfileCommunityEQ implements JSONSerializable, IdEntity
{
    use IdTrait;

    /**
     * @Column(type="string", name="community_sid")
     * @var string
     */
    private $communitySID;

    /**
     * @ManyToOne(targetEntity="CASS\Domain\Profile\Entity\Profile")
     * @JoinColumn(name="profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $profile;

    /**
     * @ManyToOne(targetEntity="CASS\Domain\Community\Entity\Community")
     * @JoinColumn(name="community_id", referencedColumnName="id")
     * @var Community
     */
    private $community;

    public function __construct(Profile $profile, Community $community) {
        $this->profile = $profile;
        $this->community = $community;
        $this->communitySID = $community->getSID();
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->getId(),
            'profile_id' => $this->getProfile()->getId(),
            'community' => $this->getCommunity()->toJSON(),
            'community_id' => $this->getCommunity()->getId(),
            'community_sid' => $this->getCommunitySID(),
        ];
    }

    public function getProfile(): Profile {
        return $this->profile;
    }

    public function getCommunity(): Community {
        return $this->community;
    }

    public function getCommunitySID(): string
    {
        return $this->communitySID;
    }
}