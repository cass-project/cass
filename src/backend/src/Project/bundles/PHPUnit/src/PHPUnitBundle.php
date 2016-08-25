<?php
namespace CASS\Project\Bundles\PHPUnit;

use Application\Bundle\GenericBundle;

final class PHPUnitBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}