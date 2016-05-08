<?php
namespace Domain;

use Application\Bundle\GenericBundle;

class DomainBundle extends GenericBundle
{
    public function getDir() {
        return __DIR__;
    }
}