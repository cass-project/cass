<?php
namespace Application\PHPUnit;

use Application\Bundle\GenericBundle;

class PHPUnitBundle extends GenericBundle
{
    public function getDir() {
        return __DIR__;
    }
}