<?php
namespace Domain\Index\Source\Sources\PublicCatalog;

use Domain\Index\Source\Source;

final class PublicContentSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_content';
    }
}