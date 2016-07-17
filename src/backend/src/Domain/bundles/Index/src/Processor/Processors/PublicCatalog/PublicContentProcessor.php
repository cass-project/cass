<?php
namespace Domain\Index\Processor\Processors\PublicCatalog;

use Domain\Index\Processor\ProcessorVariants\AbstractPostProcessor;
use Domain\Index\Source\Source;
use Domain\Post\Entity\Post;
use Domain\Post\PostType\Types\DefaultPostType;

final class PublicContentProcessor extends AbstractPostProcessor
{
    protected function getSource(Post $entity): Source
    {
        return $this->sourceFactory->getPublicContentSource();
    }

    protected function isIndexable(Post $entity): bool
    {
        return $entity->getPostTypeCode() === DefaultPostType::CODE_INT;
    }
}