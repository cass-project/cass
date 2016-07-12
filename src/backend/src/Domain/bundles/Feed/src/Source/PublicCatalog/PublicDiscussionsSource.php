<?php
namespace Domain\Feed\Source\PublicCatalog;

use Domain\Feed\Service\Entity;
use Domain\Feed\Source\Source;
use Domain\Post\Entity\Post;
use Domain\Post\PostType\Types\DiscussionPostType;

final class PublicDiscussionsSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_discussions';
    }

    public function test(Entity $entity)
    {
        return $entity instanceof Post
        && $entity->getPostTypeCode() === DiscussionPostType::CODE_INT;
    }
}