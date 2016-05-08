<?php
namespace Application\Common;

use Application\Bundle\GenericBundle;

class CommonBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}