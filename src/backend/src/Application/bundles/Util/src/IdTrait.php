<?php
namespace Application\Util;

trait IdTrait
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var int
     */
    private $id;

    public final function isPersisted() {
        return $this->id !== null;
    }

    public final function getId(): int {
        return $this->id;
    }
}