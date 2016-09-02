<?php
namespace CASS\Domain\Bundles\Index\Source;

use MongoDB\Collection;
use MongoDB\Database;

interface Source
{
    public function getMongoDBCollection(): string;
    public function ensureIndexes(Database $database, Collection $collection);
}