<?php
namespace Domain\Index\Processor;

use DI\Container;
use Domain\Collection\Entity\Collection;
use Domain\Community\Entity\Community;
use Domain\Index\Entity\IndexedEntity;
use Domain\Index\Exception\NoProcessorForEntityException;
use Domain\Index\Processor\Processors\CollectionProcessor;
use Domain\Index\Processor\Processors\CommunityProcessor;
use Domain\Index\Processor\Processors\ProfileProcessor;
use Domain\Index\Processor\Processors\PublicCatalog\PublicCollectionsProcessor;
use Domain\Index\Processor\Processors\PublicCatalog\PublicCommunitiesProcessor;
use Domain\Index\Processor\Processors\PublicCatalog\PublicContentProcessor;
use Domain\Index\Processor\Processors\PublicCatalog\PublicDiscussionsProcessor;
use Domain\Index\Processor\Processors\PublicCatalog\PublicProfilesProcessor;
use Domain\Post\Entity\Post;
use Domain\Profile\Entity\Profile;

final class ProcessorFactory
{
    /** @var Container */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function createProcessorsFor(IndexedEntity $entity): array
    {
        switch($entityClassName = get_class($entity)) {
            default:
                throw new NoProcessorForEntityException(sprintf('No entity processor available for `%s`', $entityClassName));

            case Profile::class:
                return [
                    $this->container->get(PublicProfilesProcessor::class),
                ];

            case Collection::class:
                return [
                    $this->container->get(PublicCollectionsProcessor::class),
                ];

            case Community::class:
                return [
                    $this->container->get(PublicCommunitiesProcessor::class),
                ];

            case Post::class:
                return [
                    $this->container->get(ProfileProcessor::class),
                    $this->container->get(CollectionProcessor::class),
                    $this->container->get(CommunityProcessor::class),
                    $this->container->get(PublicContentProcessor::class),
                    $this->container->get(PublicDiscussionsProcessor::class),
                ];
        }
    }
}