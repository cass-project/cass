<?php
namespace Application\Util\Entity\SIDEntity;

interface SIDEntity
{
    const SID_LENGTH = 12;
    
    public function getSID(): string;
    public function regenerateSID(): string;
}