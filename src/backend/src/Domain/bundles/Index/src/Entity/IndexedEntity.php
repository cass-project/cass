<?php
namespace Domain\Index\Entity;

use Application\Util\Entity\IdEntity\IdEntity;

interface IndexedEntity extends IdEntity
{
    public function toIndexedEntityJSON(): array ;
}