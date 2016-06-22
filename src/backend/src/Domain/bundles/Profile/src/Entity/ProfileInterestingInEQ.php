<?php
namespace Domain\Profile\Entity;

use Application\Util\Entity\IdEntity\IdEntity;
use Application\Util\Entity\IdEntity\IdTrait;
use Application\Util\JSONSerializable;
/**
 * @Entity(repositoryClass="Domain\Profile\Repository\ProfileInterestingInEQRepository")
 * @Table(name="profile_interesting_in_theme_ids")
 */

final class ProfileInterestingInEQ implements JSONSerializable, IdEntity
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