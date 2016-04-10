<?php
namespace Development;

use Common\Bootstrap\Bundle\GenericBundle;

class DevelopmentBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}