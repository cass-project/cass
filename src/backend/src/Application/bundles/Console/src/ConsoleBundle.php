<?php
namespace Application\Console;

use Application\Bundle\GenericBundle;

class ConsoleBundle extends GenericBundle
{
    public function getDir() {
        return __DIR__;
    }
}