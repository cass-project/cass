<?php
namespace Application\REST;

use Application\Bundle\GenericBundle;

class RESTBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}