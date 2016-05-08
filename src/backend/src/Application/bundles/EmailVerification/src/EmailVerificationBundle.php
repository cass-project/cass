<?php
namespace Application\EmailVerification;

use Application\Common\Bootstrap\Bundle\GenericBundle;

class EmailVerificationBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}