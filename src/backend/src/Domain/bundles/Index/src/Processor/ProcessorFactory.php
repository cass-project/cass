<?php
namespace CASS\Domain\Bundles\Index\Processor;

use DI\Container;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Index\Entity\IndexedEntity;
use CASS\Domain\Bundles\Index\Exception\NoProcessorForEntityException;
use CASS\Domain\Bundles\Index\Processor\Processors\CollectionProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\CommunityProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\ProfileProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\PersonalFeeds\PersonalCollectionsProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\PersonalFeeds\PersonalCommunitiesProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\PersonalFeeds\PersonalPeopleProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\PersonalFeeds\PersonalThemesProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\PublicCatalog\PublicCollectionsProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\PublicCatalog\PublicCommunitiesProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\PublicCatalog\PublicContentProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\PublicCatalog\PublicDiscussionsProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\PublicCatalog\PublicExpertsProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\PublicCatalog\PublicProfilesProcessor;
use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Profile\Entity\Profile;

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
                    $this->container->get(PersonalPeopleProcessor::class),
                    $this->container->get(PersonalCollectionsProcessor::class),
                    $this->container->get(PersonalCommunitiesProcessor::class),
                    $this->container->get(PersonalThemesProcessor::class),
                ];
        }
    }
}