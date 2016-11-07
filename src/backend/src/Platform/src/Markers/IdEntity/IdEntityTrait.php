<?php
namespace ZEA2\Platform\Markers\IdEntity;

trait IdEntityTrait
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

    public final function getIdNoFall()
    {
        return $this->id === null
            ? '#NEW_ENTITY'
            : $this->id;
    }
}