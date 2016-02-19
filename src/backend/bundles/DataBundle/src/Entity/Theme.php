<?php
namespace Data\Entity;

/**
 * Class Theme
 * @package Data\Entity
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

    public function toJSON()
    {
        return [
            'title' => $this->title,
            'parent_id' => $this->hasParent() ? $this->getParent()->getId() : null
        ];
    }
}