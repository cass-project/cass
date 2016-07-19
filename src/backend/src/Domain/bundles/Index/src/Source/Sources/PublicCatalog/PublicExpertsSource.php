<?php
namespace Domain\Index\Source\Sources\PublicCatalog;

use Domain\Index\Source\Source;
use MongoDB\Collection;
use MongoDB\Database;

final class PublicExpertsSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_experts';
    }

    public function ensureIndexes(Database $database, Collection $collection)
    {
    }
}