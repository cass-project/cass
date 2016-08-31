<?php
namespace ZEA2\Platform;

use CASS\Application\Bundle\GenericBundle;

final class PlatformBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}