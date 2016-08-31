<?php
namespace CASS\Application\PHPUnit;

use CASS\Application\Bundle\GenericBundle;

class PHPUnitBundle extends GenericBundle
{
    public function getDir() {
        return __DIR__;
    }
}