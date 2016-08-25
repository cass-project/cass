<?php
namespace Domain\Profile\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdTrait;
use CASS\Util\JSONSerializable;

/**
 * @Entity(repositoryClass="Domain\Profile\Repository\ProfileExpertInEQRepository")
 * @Table(name="profile_expert_in_theme_ids")
 */
final class ProfileExpertInEQ implements JSONSerializable, IdEntity
{
    use IdTrait;

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