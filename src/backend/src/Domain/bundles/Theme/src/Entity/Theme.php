<?php
namespace Domain\Theme\Entity;

use Application\Util\Entity\IdEntity\IdEntity;
use Application\Util\Entity\IdEntity\IdTrait;
use Application\Util\JSONSerializable;
use Application\Util\SerialManager\SerialEntity;
use Application\Util\SerialManager\SerialManager;
use Doctrine\ORM\PersistentCollection;

/**
 * @Entity(repositoryClass="Domain\Theme\Repository\ThemeRepository")
 * @Table(name="theme")
 */
class Theme implements JSONSerializable, IdEntity, SerialEntity
{
    const DEFAULT_PREVIEW = '';

    use IdTrait;

    /**
     * @OneToMany(targetEntity="Domain\Theme\Entity\Theme", mappedBy="parent")
     */
    private $children = [];

    /**
     * @ManyToOne(targetEntity="Domain\Theme\Entity\Theme", inversedBy="children")
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

    /**
     * @Column(type="string")
     * @var string
     */
    private $url;

    /**
     * @Column(type="string")
     * @var string
     */
    private $preview;

    public function toJSON(): array {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'url' => $this->getURL(),
            'description' => $this->getDescription(),
            'parent_id' => $this->hasParent() ? $this->getParent()->getId() : null,
            'position' => $this->getPosition(),
            'preview' => $this->getPreview(),
        ];
    }

    public function __construct(string $title)
    {
        $this->setTitle($title);
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): self {
        $this->title = $title;
        $this->url = transliterator_transliterate('Any-Latin;Latin-ASCII;', $title);

        return $this;
    }

    public function getURL(): string {
        if(! strlen($this->url)) {
            return transliterator_transliterate('Any-Latin;Latin-ASCII;', $this->getTitle());
        }else{
            return $this->url;
        }
    }

    public function setURL(string $url): self {
        $this->url = preg_replace('/[^a-zA-Z]/', '_', $url);

        return $this;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;

        return $this;
    }

    public function setPreview(string $preview): self {
        $this->preview = $preview;

        return $this;
    }

    public function getPreview(): string {
        return $this->preview;
    }

    public function hasParent(): bool {
        return $this->parent !== null;
    }

    public function getParent(): Theme {
        if (!$this->hasParent()) {
            throw new \Exception('No parent available');
        }

        return $this->parent;
    }

    public function getParentId() {
        return $this->parent === null ? null : $this->parent->getId();
    }

    public function setParent(Theme $parent = null): self {
        if ($parent && $this->isPersisted() && $parent->getId() === $this->getId()) {
            throw new \Exception('Unable to setup parent');
        }

        $this->parent = $parent;

        return $this;
    }

    public function getChildren(): PersistentCollection {
        return $this->children;
    }

    public function hasChildren(): bool {
        return count($this->children) > 0;
    }

    public function getPosition(): int {
        return $this->position;
    }

    public function setPosition(int $position): self {
        if ($position <= 1) {
            $position = 1;
        }

        $this->position = $position;

        return $this;
    }

    public function incrementPosition() {
        ++$this->position;
    }
}