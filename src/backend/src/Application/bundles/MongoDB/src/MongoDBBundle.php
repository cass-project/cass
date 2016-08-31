<?php
namespace CASS\Application\MongoDB;

use CASS\Application\Bundle\GenericBundle;

final class MongoDBBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}