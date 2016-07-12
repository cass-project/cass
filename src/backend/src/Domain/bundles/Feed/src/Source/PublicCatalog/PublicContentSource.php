<?php
namespace Domain\Feed\Source\PublicCatalog;

use Domain\Feed\Service\Entity;
use Domain\Feed\Source\Source;
use Domain\Post\Entity\Post;
use Domain\Post\PostType\Types\DefaultPostType;

final class PublicContentSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_content';
    }

    public function test(Entity $entity)
    {
        return $entity instanceof Post
            && $entity->getPostTypeCode() === DefaultPostType::CODE_INT;
    }
}