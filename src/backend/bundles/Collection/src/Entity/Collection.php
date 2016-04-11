<?php
namespace Collection\Entity;

use Data\Entity\Theme;
use Doctrine\ORM\PersistentCollection;
use Profile\Entity\Profile;

/**
 * @Entity(repositoryClass="Collection\Repository\CollectionRepository")
 * @Table(name="collection")
 */
class Collection
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @OneToMany(targetEntity="Collection\Entity\Collection", mappedBy="parent")
     * @var PersistentCollection
     */
    private $children = [];

    /**
     * @ManyToOne(targetEntity="Collection\Entity\Collection", inversedBy="children")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     * @var Theme|null
     */
    private $parent = null;

    /**
     * @ManyToOne(targetEntity="Profile\Entity\Profile")
     * @JoinColumn(name="profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $profile;

    /**
     * @ManyToOne(targetEntity="Data\Entity\Theme")
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

    /**
     * @Column(type="integer")
     * @var int
     */
    private $position = 1;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function hasId(): bool
    {
        return $this->id !== null;
    }

    public function hasParent(): bool
    {
        return $this->parent !== null;
    }

    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function getChildren(): PersistentCollection
    {
        return $this->children;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): self
    {
        $this->profile = $profile;
        return $this;
    }

    public function getTheme(): Theme
    {
        return $this->theme;
    }

    public function unsetTheme()
    {
        $this->theme = null;
    }

    public function hasTheme()
    {
        return $this->theme !== null;
    }

    public function setTheme($theme): self
    {
        $this->theme = $theme;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;
        return $this;
    }
}