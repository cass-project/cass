<?php
namespace Domain\Avatar;

use Application\Bundle\GenericBundle;

final class AvatarBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}