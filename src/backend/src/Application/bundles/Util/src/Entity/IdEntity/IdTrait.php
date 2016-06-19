<?php
namespace Application\Util\Entity\IdEntity;

trait IdTrait
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var int
     */
    private $id;

    public final function isPersisted(): bool
    {
        return $this->id !== null;
    }

    public final function getId(): int 
    {
        return $this->id;
    }
}