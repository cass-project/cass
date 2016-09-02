<?php
namespace CASS\Domain\Index\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;

interface IndexedEntity extends IdEntity
{
    public function toIndexedEntityJSON(): array ;
}