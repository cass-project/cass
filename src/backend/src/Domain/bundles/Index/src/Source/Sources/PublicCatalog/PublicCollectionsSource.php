<?php
namespace Domain\Index\Source\Sources\PublicCatalog;

use Domain\Feed\Source\Source;

final class PublicCollectionsSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_collections';
    }
}