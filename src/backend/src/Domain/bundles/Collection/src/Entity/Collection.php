<?php
namespace Domain\Collection\Entity;

use Application\Util\IdTrait;
use Application\Util\JSONSerializable;
use Domain\Community\Entity\Community;
use Domain\Profile\Entity\Profile;
use Domain\Theme\Entity\Theme;

/**
 * @Entity(repositoryClass="Domain\Collection\Repository\CollectionRepository")
 * @Table(name="collection")
 */
class Collection implements JSONSerializable
{
    use IdTrait;

    /**
     * @Column(type="string", name="owner_sid")
     * @var string
     */
    private $ownerSID;

    /**
     * @ManyToOne(targetEntity="Domain\Theme\Entity\Theme")
     * @JoinColumn(name="theme_id", referencedColumnName="id")
     * @var Theme
     */
    private $theme;

    /**
     * @Column(type="string")
     * @var string
     */
    private $title;

    /**
     * @Column(type="string")
     * @var string
     */
    private $description;

    public function __construct(string $ownerSID, string $title, string $description, Theme $theme = null)
    {
        $this->ownerSID = $ownerSID;
        $this->theme = $theme;
        $this->title = $title;
        $this->description = $description;
    }

    public function toJSON(): array {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'has_theme' => $this->hasTheme(),
            'theme_id' => $this->hasTheme() ? $this->getTheme()->getId() : null,
        ];
    }

    public function getOwnerSID(): string
    {
        return $this->ownerSID;
    }

    public function getTheme(): Theme {
        return $this->theme;
    }

    public function unsetTheme() {
        $this->theme = null;
    }

    public function hasTheme() {
        return $this->theme !== null;
    }

    public function setTheme($theme): self {
        $this->theme = $theme;
        return $this;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): self {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;
        return $this;
    }

    public function setOwnerProfile(int $profileId )
    {
        $this->ownerSID = sprintf('profile:%d', $profileId);
        return $this;
    }

    public function setOwnerCommunity(int $communityId)
    {
        $this->ownerSID = sprintf('community:%d', $communityId);
        return $this;
    }
}