<?php
namespace CASS\Domain\Bundles\Feed\Search\Stream;

use CASS\Domain\Bundles\Feed\Search\Stream\Streams\CollectionStream;
use CASS\Domain\Bundles\Feed\Search\Stream\Streams\CommunityStream;
use CASS\Domain\Bundles\Feed\Search\Stream\Streams\PostStream;
use CASS\Domain\Bundles\Feed\Search\Stream\Streams\ProfileStream;
use CASS\Domain\Bundles\Index\Source\Source;
use CASS\Domain\Bundles\Index\Source\Sources\CollectionSource;
use CASS\Domain\Bundles\Index\Source\Sources\CommunitySource;
use CASS\Domain\Bundles\Index\Source\Sources\ProfileSource;
use CASS\Domain\Bundles\Index\Source\Sources\PublicCatalog\PublicCollectionsSource;
use CASS\Domain\Bundles\Index\Source\Sources\PublicCatalog\PublicCommunitiesSource;
use CASS\Domain\Bundles\Index\Source\Sources\PublicCatalog\PublicContentSource;
use CASS\Domain\Bundles\Index\Source\Sources\PublicCatalog\PublicDiscussionsSource;
use CASS\Domain\Bundles\Index\Source\Sources\PublicCatalog\PublicProfilesSource;
use CASS\Domain\Bundles\Index\Source\Sources\PublicCatalog\PublicExpertsSource;
use Interop\Container\ContainerInterface;
use Zend\I18n\Exception\OutOfBoundsException;

final class StreamFactory
{
    /** @var ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getStreamForSource(Source $source)
    {
        $sourceName = get_class($source);

        if (in_array($sourceName, [
            PublicProfilesSource::class,
            PublicExpertsSource::class,
        ])) {
            $stream = $this->container->get(ProfileStream::class);
            $stream->setSource($source);

            return $stream;
        } else if (in_array($sourceName, [
            PublicContentSource::class,
            PublicDiscussionsSource::class,
            ProfileSource::class,
            CollectionSource::class,
        ])) {
            $stream = $this->container->get(PostStream::class);
            $stream->setSource($source);

            return $stream;
        } else if (in_array($sourceName, [
            PublicCollectionsSource::class
        ])) {
            $stream = $this->container->get(CollectionStream::class);
            $stream->setSource($source);

            return $stream;
        } else if (in_array($sourceName, [
            PublicCommunitiesSource::class,
            CommunitySource::class,
        ])) {
            $stream = $this->container->get(CommunityStream::class);
            $stream->setSource($source);

            return $stream;
        } else {
            throw new OutOfBoundsException(sprintf('Cannot create stream for source `%s`', $sourceName));
        }
    }
}