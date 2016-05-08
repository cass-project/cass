<?php
namespace Domain\EmailVerification;

use Application\Bundle\GenericBundle;

class EmailVerificationBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}