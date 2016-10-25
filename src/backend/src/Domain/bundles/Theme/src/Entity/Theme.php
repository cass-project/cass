<?php
namespace CASS\Domain\Bundles\Theme\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdEntityTrait;
use CASS\Util\JSONSerializable;
use CASS\Util\SerialManager\SerialEntity;
use CASS\Util\SerialManager\SerialManager;
use Doctrine\ORM\PersistentCollection;

/**
 * @Entity(repositoryClass="CASS\Domain\Bundles\Theme\Repository\ThemeRepository")
 * @Table(name="theme")
 */
class Theme implements JSONSerializable, IdEntity, SerialEntity
{
    const DEFAULT_PREVIEW = 'default.png';

    use IdEntityTrait;

    /**
     * @OneToMany(targetEntity="CASS\Domain\Bundles\Theme\Entity\Theme", mappedBy="parent")
     */
    private $children = [];

    /**
     * @ManyToOne(targetEntity="CASS\Domain\Bundles\Theme\Entity\Theme", inversedBy="children")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     * @var Theme|null
     */
    private $parent;

    /**
     * @Column(type="integer", name="position")
     */
    private $position = SerialManager::POSITION_LAST;

    /**
     * @Column(type="string", name="title")
     * @var string
     */
    private $title;

    /**
     * @Column(type="text", name="description")
     * @var string
     */
    private $description = '';

    /**
     * @Column(type="string", name="url")
     * @var string
     */
    private $url;

    /**
     * @Column(type="string", name="preview")
     * @var string
     */
    private $preview = self::DEFAULT_PREVIEW;

    public function toJSON(): array {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'url' => $this->getURL(),
            'description' => $this->getDescription(),
            'parent_id' => $this->hasParent() ? $this->getParent()->getId() : null,
            'position' => $this->getPosition(),
            'preview' => $this->getPreview(),
            'subscribed' => false,
        ];
    }

    public function __construct(string $title, int $forceId = null)
    {
        if($forceId) {
            $this->id = $forceId;
        }

        $this->setTitle($title);
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): self {
        $this->title = $title;
        $this->url = $this->generateURL();

        return $this;
    }

    public function getURL(): string
    {
        if(! strlen($this->url)) {
            $this->url = $this->generateURL();
        }

        return $this->url;
    }

    private function generateURL(): string
    {
        $nonLatinRegex = '/[^a-zA-Z\_]/';

        $title = mb_strtolower($this->getTitle());
        $result = transliterator_transliterate('Russian-Latin/BGN;', $title);
        $result = str_replace(' ', '_', $result);

        if(preg_match($nonLatinRegex, $result)) {
            $result = transliterator_transliterate('Any-Latin;Latin-ASCII;', $result);
        }

        $result = preg_replace($nonLatinRegex, '_', $result);

        while(strpos($result, '__') !== false) {
            $result = str_replace('__', '_', $result);
        }

        return $result;
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