<?php
namespace Application\Util\Entity\IdEntity;

interface IdEntity
{
    public function isPersisted(): bool;
    public function getId(): int;
}