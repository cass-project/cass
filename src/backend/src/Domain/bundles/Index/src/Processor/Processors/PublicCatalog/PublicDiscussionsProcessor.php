<?php
namespace CASS\Domain\Index\Processor\Processors\PublicCatalog;

use CASS\Domain\Index\Source\Source;
use CASS\Domain\Index\Processor\ProcessorVariants\AbstractPostProcessor;
use CASS\Domain\Post\Entity\Post;
use CASS\Domain\Post\PostType\Types\DiscussionPostType;

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