<?php
namespace Host;

use Common\Bootstrap\Bundle\GenericBundle;

class HostBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}