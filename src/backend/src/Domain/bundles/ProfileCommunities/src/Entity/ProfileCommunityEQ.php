<?php
namespace Domain\ProfileCommunities\Entity;

use Application\Util\IdTrait;
use Application\Util\JSONSerializable;
use Domain\Community\Entity\Community;
use Domain\Profile\Entity\Profile;

/**
 * @Entity(repositoryClass="Domain\ProfileCommunities\Repository\ProfileCommunitiesRepository")
 * @Table(name="profile_communities")
 */
class ProfileCommunityEQ implements JSONSerializable
{
    use IdTrait;

    /**
     * @ManyToOne(targetEntity="Domain\Profile\Entity\Profile")
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
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->getId(),
            'profile_id' => $this->getProfile()->getId(),
            'community' => $this->getCommunity()->toJSON()
        ];
    }

    public function getProfile(): Profile {
        return $this->profile;
    }

    public function getCommunity(): Community {
        return $this->community;
    }
}