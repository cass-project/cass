<?php
namespace Application;

use Application\Bootstrap\Bundle\GenericBundle;

class ApplicationBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}