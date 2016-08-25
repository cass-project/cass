<?php
namespace CASS\Util\Entity\IdEntity;

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

    public final function getIdNoFall(): string
    {
        return $this->id === null
            ? '#NEW_ENTITY'
            : (string) $this->id;
    }
}