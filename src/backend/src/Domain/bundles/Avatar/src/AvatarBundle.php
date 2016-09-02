<?php
namespace CASS\Domain\Avatar;

use CASS\Application\Bundle\GenericBundle;

final class AvatarBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}