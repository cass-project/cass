<?php
namespace Domain\Fake;

use Application\Bundle\GenericBundle;

class FakeBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}