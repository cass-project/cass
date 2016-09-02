<?php
namespace CASS\Domain\Feed\Search\Stream;

use CASS\Domain\Collection\Service\CollectionService;
use CASS\Domain\Community\Service\CommunityService;
use CASS\Domain\Feed\Search\Stream\Streams\CollectionStream;
use CASS\Domain\Feed\Search\Stream\Streams\CommunityStream;
use CASS\Domain\Feed\Search\Stream\Streams\PostStream;
use CASS\Domain\Feed\Search\Stream\Streams\ProfileStream;
use CASS\Domain\Index\Source\Source;
use CASS\Domain\Index\Source\Sources\CollectionSource;
use CASS\Domain\Index\Source\Sources\CommunitySource;
use CASS\Domain\Index\Source\Sources\ProfileSource;
use CASS\Domain\Index\Source\Sources\PublicCatalog\PublicCollectionsSource;
use CASS\Domain\Index\Source\Sources\PublicCatalog\PublicCommunitiesSource;
use CASS\Domain\Index\Source\Sources\PublicCatalog\PublicContentSource;
use CASS\Domain\Index\Source\Sources\PublicCatalog\PublicDiscussionsSource;
use CASS\Domain\Index\Source\Sources\PublicCatalog\PublicProfilesSource;
use CASS\Domain\Index\Source\Sources\PublicCatalog\PublicExpertsSource;
use CASS\Domain\Post\Formatter\PostFormatter;
use CASS\Domain\Post\Service\PostService;
use CASS\Domain\Profile\Service\ProfileService;
use Zend\I18n\Exception\OutOfBoundsException;

final class StreamFactory
{
    /** @var PostFormatter */
    private $postFormatter;

    /** @var PostService */
    private $postService;

    /** @var ProfileService */
    private $profileService;

    /** @var CollectionService */
    private $collectionService;

    /** @var CommunityService */
    private $communityService;

    public function __construct(
        PostFormatter $postFormatter,
        PostService $postService,
        ProfileService $profileService,
        CollectionService $collectionService,
        CommunityService $communityService
    ) {
        $this->postFormatter = $postFormatter;
        $this->postService = $postService;
        $this->profileService = $profileService;
        $this->collectionService = $collectionService;
        $this->communityService = $communityService;
    }

    public function getStreamForSource(Source $source) {
        $sourceName = get_class($source);

        if(in_array($sourceName, [
            PublicProfilesSource::class,
            PublicExpertsSource::class,
        ])) {
            $stream = new ProfileStream($source);
            $stream->setProfileService($this->profileService);

            return $stream;
        }else if(in_array($sourceName, [
            PublicContentSource::class,
            PublicDiscussionsSource::class,
            ProfileSource::class,
            CollectionSource::class,
        ])) {
            $stream = new PostStream($source);
            $stream->setPostFormatter($this->postFormatter);
            $stream->setPostService($this->postService);

            return $stream;
        }else if(in_array($sourceName, [
            PublicCollectionsSource::class
        ])) {
            $stream = new CollectionStream($source);
            $stream->setCollectionService($this->collectionService);

            return $stream;
        }else if(in_array($sourceName, [
            PublicCommunitiesSource::class,
            CommunitySource::class,
        ])) {
            $stream = new CommunityStream($source);
            $stream->setCommunityService($this->communityService);

            return $stream;
        }else{
            throw new OutOfBoundsException(sprintf('Cannot create stream for source `%s`', $sourceName));
        }
    }
}