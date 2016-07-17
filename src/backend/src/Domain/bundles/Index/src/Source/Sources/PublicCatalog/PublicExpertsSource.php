<?php
namespace Domain\Index\Source\Sources\PublicCatalog;

use Domain\Feed\Source\Source;

final class PublicExpertsSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_experts';
    }
}