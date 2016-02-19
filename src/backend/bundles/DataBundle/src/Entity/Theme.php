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
     */
    private $parent;

    /**
     * @Column(type="string")
     * @var string
     */
    private $title;

    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setParent(Theme $parent = null)
    {
        $this->parent = $parent;
    }
}