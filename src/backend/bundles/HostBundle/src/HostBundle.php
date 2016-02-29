<?php
namespace Host;

use Application\Bootstrap\Bundle\GenericBundle;

class HostBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}