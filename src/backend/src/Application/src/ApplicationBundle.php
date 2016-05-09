<?php
namespace Application;

use Application\Bundle\GenericBundle;

class ApplicationBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}