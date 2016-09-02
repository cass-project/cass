<?php
namespace CASS\Application\Bundles\Stage;

use CASS\Application\Bundle\GenericBundle;

final class StageBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}