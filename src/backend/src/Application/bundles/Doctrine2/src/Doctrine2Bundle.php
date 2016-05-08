<?php
namespace Application\Doctrine2;

use Application\Bundle\GenericBundle;

class Doctrine2Bundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}