<?php
namespace CASS\Domain\Bundles\Index\Processor\Processors\PublicCatalog;

use CASS\Domain\Bundles\Index\Processor\ProcessorVariants\AbstractPostProcessor;
use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Post\PostType\Types\DefaultPostType;

final class PublicContentProcessor extends AbstractPostProcessor
{
    protected function getSources(Post $entity): array
    {
        return [
            $this->sourceFactory->getPublicContentSource(),
        ];
    }

    protected function isIndexable(Post $entity): bool
    {
        return $entity->getPostTypeCode() === DefaultPostType::CODE_INT;
    }
}