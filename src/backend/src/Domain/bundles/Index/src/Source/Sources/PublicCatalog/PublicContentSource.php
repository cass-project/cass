<?php
namespace Domain\Index\Source\Sources\PublicCatalog;

use Domain\Feed\Source\PublicCatalog\string;
use Domain\Feed\Source\Source;

final class PublicContentSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_content';
    }
}