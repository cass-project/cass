<?php
namespace CASS\Domain\Collection;

use CASS\Application\Bundle\GenericBundle;

class CollectionBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}