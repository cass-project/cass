<?php
namespace Domain\Collection\Entity;

use Application\Util\JSONSerializable;
use Application\Util\SerialManager\SerialEntity;
use Domain\Theme\Entity\Theme;
use Doctrine\ORM\PersistentCollection;
use Domain\Profile\Entity\Profile;

/**
 * @Entity(repositoryClass="Domain\Collection\Repository\CollectionRepository")
 * @Table(name="collection")
 */
class Collection implements SerialEntity, JSONSerializable
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @OneToMany(targetEntity="Domain\Collection\Entity\Domain\Collection", mappedBy="parent")
     * @var PersistentCollection
     */
    private $children = [];

    /**
     * @ManyToOne(targetEntity="Domain\Collection\Entity\Domain\Collection", inversedBy="children")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     * @var Theme|null
     */
    private $parent = null;

    /**
     * @ManyToOne(targetEntity="Domain\Profile\Entity\Domain\Profile")
     * @JoinColumn(name="profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $profile;

    /**
     * @ManyToOne(targetEntity="Domain\Theme\Entity\Domain\Theme")
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

    public function setParent($parent) : self
    {
        $this->parent = $parent;
        return $this;
    }

    public function getParentId()
    {
        return $this->parent === null ? null : $this->parent->getId();
    }

    public function getParent(): Collection
    {
        if(!$this->hasParent()) {
            throw new \Exception('No parent available');
        }

        return $this->parent;
    }

    public function getChildren(): PersistentCollection
    {
        return $this->children;
    }

    public function hasChildren(): bool
    {
        return count($this->children) > 0;
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

    public function incrementPosition()
    {
        ++$this->position;
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'parent_id' => $this->hasParent() ? $this->getParent()->getId() : null,
            'theme_id' => $this->hasTheme() ? $this->getTheme()->getId() : null,
            'position' => $this->getPosition()
        ];
    }
}