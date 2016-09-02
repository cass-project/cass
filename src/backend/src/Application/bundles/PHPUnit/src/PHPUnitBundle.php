<?php
namespace CASS\Application\Bundles\PHPUnit;

use CASS\Application\Bundle\GenericBundle;

final class PHPUnitBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}