<?php
namespace Domain\Feed\Search\Stream;

use Domain\Feed\Middleware\Command\PublicExpertsCommand;
use Domain\Feed\Source\CollectionSource;
use Domain\Feed\Source\ProfileSource;
use Domain\Feed\Source\PublicCatalog\PublicCollectionsSource;
use Domain\Feed\Source\PublicCatalog\PublicCommunitiesSource;
use Domain\Feed\Source\PublicCatalog\PublicContentSource;
use Domain\Feed\Source\PublicCatalog\PublicDiscussionsSource;
use Domain\Feed\Source\PublicCatalog\PublicProfilesSource;
use Domain\Feed\Source\Source;
use Zend\I18n\Exception\OutOfBoundsException;

final class StreamFactory
{
    public function getStreamForSource(Source $source) {
        $sourceName = get_class($source);

        if(in_array($sourceName, [
            PublicProfilesSource::class,
            PublicExpertsCommand::class,
        ])) {
            return new ProfileStream($source);
        }else if(in_array($sourceName, [
            PublicContentSource::class,
            PublicDiscussionsSource::class,
            ProfileSource::class,
            CollectionSource::class,
        ])) {
            return new PostStream($source);
        }else if(in_array($sourceName, [
            PublicCollectionsSource::class
        ])) {
            return new CollectionStream($source);
        }else if(in_array($sourceName, [
            PublicCommunitiesSource::class
        ])) {
            return new CommunityStream($source);
        }else{
            throw new OutOfBoundsException(sprintf('Cannot create stream for source `%s`', $sourceName));
        }
    }
}