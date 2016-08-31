<?php
namespace CASS\Project\Bundles\Console;

use CASS\Application\Bundle\GenericBundle;

final class ConsoleBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}