<?php
namespace CASS\Domain\Index\Processor\Processors\PublicCatalog;

use CASS\Domain\Index\Processor\ProcessorVariants\AbstractPostProcessor;
use CASS\Domain\Index\Source\Source;
use CASS\Domain\Post\Entity\Post;
use CASS\Domain\Post\PostType\Types\DefaultPostType;

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