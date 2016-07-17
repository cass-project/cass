<?php
namespace Domain\Index;

use Application\Bundle\GenericBundle;

final class IndexBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}