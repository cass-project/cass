<?php
namespace Data\Entity;

/**
 * @Entity(repositoryClass="Data\Repository\HostRepository")
 * @Table(name="host")
 */
class Host
{
    /** @var int */
    private $id;

    /** @var string */
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
}