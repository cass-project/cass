<?php
namespace CASS\Domain\Index\Processor;

use DI\Container;
use CASS\Domain\Collection\Entity\Collection;
use CASS\Domain\Community\Entity\Community;
use CASS\Domain\Index\Entity\IndexedEntity;
use CASS\Domain\Index\Exception\NoProcessorForEntityException;
use CASS\Domain\Index\Processor\Processors\CollectionProcessor;
use CASS\Domain\Index\Processor\Processors\CommunityProcessor;
use CASS\Domain\Index\Processor\Processors\ProfileProcessor;
use CASS\Domain\Index\Processor\Processors\PublicCatalog\PublicCollectionsProcessor;
use CASS\Domain\Index\Processor\Processors\PublicCatalog\PublicCommunitiesProcessor;
use CASS\Domain\Index\Processor\Processors\PublicCatalog\PublicContentProcessor;
use CASS\Domain\Index\Processor\Processors\PublicCatalog\PublicDiscussionsProcessor;
use CASS\Domain\Index\Processor\Processors\PublicCatalog\PublicExpertsProcessor;
use CASS\Domain\Index\Processor\Processors\PublicCatalog\PublicProfilesProcessor;
use CASS\Domain\Post\Entity\Post;
use CASS\Domain\Profile\Entity\Profile;

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
                    $this->container->get(PublicExpertsProcessor::class),
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