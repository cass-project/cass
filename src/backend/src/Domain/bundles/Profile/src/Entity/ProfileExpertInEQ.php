<?php
namespace CASS\Domain\Bundles\Profile\Entity;

use ZEA2\Platform\Markers\IdEntity\IdEntity;
use ZEA2\Platform\Markers\IdEntity\IdEntityTrait;
use CASS\Util\JSONSerializable;

/**
 * @Entity(repositoryClass="CASS\Domain\Bundles\Profile\Repository\ProfileExpertInEQRepository")
 * @Table(name="profile_expert_in_theme_ids")
 */
final class ProfileExpertInEQ implements JSONSerializable, IdEntity
{
    use IdEntityTrait;

    /**
     * @Column(type="integer", name="profile_id")
     * @var int
     */
    private $profileId;

    /**
     * @Column(type="integer", name="theme_id")
     * @var int
     */
    private $themeId;

    public function __construct(int $profileId, int $themeId)
    {
        $this->profileId = $profileId;
        $this->themeId = $themeId;
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->getId(),
            'profile_id' => $this->getProfileId(),
            'theme_id' => $this->getThemeId(),
        ];
    }

    public function getProfileId(): int
    {
        return $this->profileId;
    }

    public function getThemeId(): int
    {
        return $this->themeId;
    }
}