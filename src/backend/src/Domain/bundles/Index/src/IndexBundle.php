<?php
namespace CASS\Domain\Index;

use CASS\Application\Bundle\GenericBundle;

final class IndexBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}