<?php
namespace Application\Common;

use Application\Common\Bootstrap\Bundle\GenericBundle;

class CommonBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}