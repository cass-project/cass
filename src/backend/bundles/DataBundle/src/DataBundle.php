<?php
namespace Data;

use Application\Bootstrap\Bundle\GenericBundle;

class DataBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}