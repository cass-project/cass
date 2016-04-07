<?php
namespace Development;

use Application\Bootstrap\Bundle\GenericBundle;

class DevelopmentBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}