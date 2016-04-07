<?php
namespace Auth;

use Application\Bootstrap\Bundle\GenericBundle;

class AuthBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}