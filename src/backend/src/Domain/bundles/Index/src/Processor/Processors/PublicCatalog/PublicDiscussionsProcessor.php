<?php
namespace Domain\Index\Processor\Processors\PublicCatalog;

use Domain\Index\Source\Source;
use Domain\Index\Processor\ProcessorVariants\AbstractPostProcessor;
use Domain\Post\Entity\Post;
use Domain\Post\PostType\Types\DiscussionPostType;

final class PublicDiscussionsProcessor extends AbstractPostProcessor
{
    protected function getSource(Post $entity): Source
    {
        return $this->sourceFactory->getPublicDiscussionsSource();
    }

    protected function isIndexable(Post $entity): bool
    {
        return $entity->getPostTypeCode() === DiscussionPostType::CODE_INT;
    }
}