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

    public function __construct(string $title, string $description, Theme $theme = null)
    {
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
}