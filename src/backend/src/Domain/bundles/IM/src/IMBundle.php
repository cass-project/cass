<?php
namespace Domain\IM;

use Application\Bundle\GenericBundle;

class IMBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}