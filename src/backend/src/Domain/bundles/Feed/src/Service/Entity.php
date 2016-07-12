<?php
namespace Domain\Feed\Service;

use Application\Util\Entity\IdEntity\IdEntity;
use Application\Util\JSONSerializable;

interface Entity extends IdEntity
{
    public function toIndexedJSON(): array;
}