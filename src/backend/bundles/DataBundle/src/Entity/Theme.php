<?php
namespace Data\Entity;

/**
 * @Entity(repositoryClass="Data\Repository\ThemeRepository")
 * @Table(name="theme")
 */
class Theme
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @OneToMany(targetEntity="Data\Entity\Theme", mappedBy="parent")
     */
    private $children = [];

    /**
     * @ManyToOne(targetEntity="Theme", inversedBy="children")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     * @var Theme|null
     */
    private $parent;

    /**
     * @ManyToOne(targetEntity="Data\Entity\Host")
     * @JoinColumn(name="host_id", referencedColumnName="id")
     */
    private $host;

    /**
     * @Column(type="integer")
     */
    private $position = 1;

    /**
     * @Column(type="string")
     * @var string
     */
    private $title;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function hasParent()
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

    public function setParent(Theme $parent = null)
    {
        $this->parent = $parent;
    }

    public function getHost(): Host
    {
        return $this->host;
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

    public function inrementPosition()
    {
        ++$this->position;
    }

    public function toJSON()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'parent_id' => $this->hasParent() ? $this->getParent()->getId() : null,
            'host' => $this->getHost()->toJSON(),
            'position' => $this->getPosition()
        ];
    }
}