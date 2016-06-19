<?php
namespace Domain\ProfileCommunities\Entity;

use Application\Util\Entity\IdEntity\IdEntity;
use Application\Util\Entity\IdEntity\IdTrait;
use Application\Util\JSONSerializable;
use Domain\Community\Entity\Community;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\Profile\Greetings;

/**
 * @Entity(repositoryClass="Domain\ProfileCommunities\Repository\ProfileCommunitiesRepository")
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
     * @ManyToOne(targetEntity="Domain\Profile\Entity\Profile\Greetings")
     * @JoinColumn(name="profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $profile;

    /**
     * @ManyToOne(targetEntity="Domain\Community\Entity\Community")
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
            'community_id' => $this->getProfile()->getId(),
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