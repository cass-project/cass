<?php
namespace ZEA2\Platform\Bundles\PHPUnit;

use CASS\Application\Bundle\GenericBundle;

class PHPUnitBundle extends GenericBundle
{
    public function getDir() {
        return __DIR__;
    }
}