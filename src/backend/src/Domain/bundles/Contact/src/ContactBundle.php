<?php
namespace Domain\Contact;

use Application\Bundle\GenericBundle;

final class ContactBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}