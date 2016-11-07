<?php
namespace CASS\Domain\Bundles\Index\Entity;

use ZEA2\Platform\Markers\IdEntity\IdEntity;

interface IndexedEntity extends IdEntity
{
    public function toIndexedEntityJSON(): array ;
}