<?php
namespace Application\MongoDB;

use Application\Bundle\GenericBundle;

final class MongoDBBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}