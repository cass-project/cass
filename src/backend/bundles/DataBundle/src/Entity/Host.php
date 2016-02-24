<?php
namespace Data\Entity;

/**
 * @Entity(repositoryClass="Data\Repository\HostRepository")
 * @Table(name="host")
 */
class Host
{
    /**
     * @Id
     * @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $domain;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function toJSON()
    {
        return [
            'id' => $this->getId(),
            'domain' => $this->getDomain()
        ];
    }
}