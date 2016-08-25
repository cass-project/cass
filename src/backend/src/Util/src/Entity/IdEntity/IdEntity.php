<?php
namespace CASS\Util\Entity\IdEntity;

interface IdEntity
{
    public function isPersisted(): bool;
    public function getId(): int;
    public function getIdNoFall(): string;
}