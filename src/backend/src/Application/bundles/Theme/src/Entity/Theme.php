<?php
namespace Application\Theme\Entity;

use Application\Common\REST\JSONSerializable;
use Application\Common\Tools\SerialManager\SerialEntity;
use Application\Common\Tools\SerialManager\SerialManager;
use Doctrine\ORM\PersistentCollection;

/**
 * @Entity(repositoryClass="Application\Theme\Repository\ThemeRepository")
 * @Table(name="theme")
 */
class Theme implements SerialEntity, JSONSerializable
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @OneToMany(targetEntity="Application\Theme\Entity\Application\Theme", mappedBy="parent")
     */
    private $children = [];

    /**
     * @ManyToOne(targetEntity="Application\Theme", inversedBy="children")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     * @var Theme|null
     */
    private $parent;

    /**
     * @Column(type="integer")
     */
    private $position = SerialManager::POSITION_LAST;

    /**
     * @Column(type="string")
     * @var string
     */
    private $title;

    /**
     * @Column(type="text")
     * @var string
     */
    private $description = '';

    public function getId(): int
    {
        return $this->id;
    }

    public function hasId(): int
    {
        return $this->id !== null;
    }

    public function isNewEntity(): bool
    {
        return $this->hasId() === false;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description) {
        $this->description = $description;
    }

    public function hasParent(): bool
    {
        return $this->parent !== null;
    }

    public function getParent(): Theme
    {
        if(!$this->hasParent()) {
            throw new \Exception('No parent available');
        }

        return $this->parent;
    }

    public function getParentId()
    {
        return $this->parent === null ? null : $this->parent->getId();
    }

    public function setParent(Theme $parent = null): self
    {
        if($parent && $this->hasId() && $parent->getId() === $this->getId()) {
            throw new \Exception('Unable to setup parent');
        }

        $this->parent = $parent;

        return $this;
    }

    public function getChildren(): PersistentCollection
    {
        return $this->children;
    }

    public function hasChildren(): bool
    {
        return count($this->children) > 0;
    }

    public function setHost($host): self
    {
        $this->host = $host;

        return $this;
    }
    
    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        if($position <= 1) {
            $position = 1;
        }

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
            'parent_id' => $this->hasParent() ? $this->getParent()->getId() : null,
            'position' => $this->getPosition()
        ];
    }
}