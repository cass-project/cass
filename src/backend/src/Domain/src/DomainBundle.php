<?php
namespace Domain;

use CASS\Application\Bundle\GenericBundle;

class DomainBundle extends GenericBundle
{
    public function getDir() {
        return __DIR__;
    }
}