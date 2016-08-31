<?php
namespace Domain\EmailVerification;

use CASS\Application\Bundle\GenericBundle;

class EmailVerificationBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}