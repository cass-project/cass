<?php
namespace Domain\Feed\Search\Stream;

use Domain\Collection\Service\CollectionService;
use Domain\Community\Service\CommunityService;
use Domain\Index\Source\Source;
use Domain\Index\Source\Sources\CollectionSource;
use Domain\Index\Source\Sources\ProfileSource;
use Domain\Index\Source\Sources\PublicCatalog\PublicCollectionsSource;
use Domain\Index\Source\Sources\PublicCatalog\PublicCommunitiesSource;
use Domain\Index\Source\Sources\PublicCatalog\PublicContentSource;
use Domain\Index\Source\Sources\PublicCatalog\PublicDiscussionsSource;
use Domain\Index\Source\Sources\PublicCatalog\PublicProfilesSource;
use Domain\Index\Source\Sources\PublicCatalog\PublicExpertsSource;
use Domain\Post\Formatter\PostFormatter;
use Domain\Post\Service\PostService;
use Domain\Profile\Service\ProfileService;
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

            return $stream;
        }else if(in_array($sourceName, [
            PublicCommunitiesSource::class
        ])) {
            return new CommunityStream($source);
        }else{
            throw new OutOfBoundsException(sprintf('Cannot create stream for source `%s`', $sourceName));
        }
    }
}