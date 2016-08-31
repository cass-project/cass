<?php
namespace CASS\Application;

use CASS\Application\Bundle\GenericBundle;

class ApplicationBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}