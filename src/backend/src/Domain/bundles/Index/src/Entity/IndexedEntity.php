<?php
namespace Domain\Index\Entity;

interface IndexedEntity
{
    public function toIndexedEntityJSON(): array ;
}