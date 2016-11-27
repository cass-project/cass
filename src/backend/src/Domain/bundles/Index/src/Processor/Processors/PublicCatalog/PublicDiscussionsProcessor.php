<?php
namespace CASS\Domain\Bundles\Index\Processor\Processors\PublicCatalog;

use CASS\Domain\Bundles\Index\Source\Source;
use CASS\Domain\Bundles\Index\Processor\ProcessorVariants\AbstractPostProcessor;
use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Post\PostType\Types\DiscussionPostType;

final class PublicDiscussionsProcessor extends AbstractPostProcessor
{
    protected function getSources(Post $entity): array
    {
        return [
            $this->sourceFactory->getPublicDiscussionsSource(),
        ];
    }

    protected function isIndexable(Post $entity): bool
    {
        return $entity->getPostTypeCode() === DiscussionPostType::CODE_INT;
    }
}