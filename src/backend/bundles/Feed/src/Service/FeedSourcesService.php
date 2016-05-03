<?php
namespace Feed\Service;

use Feed\Feed\Source\Collection\CollectionSource;
use Feed\Formatter\ResultSetFormatter;
use Post\Repository\PostRepository;
use Profile\Repository\ProfileRepository;

class FeedSourcesService /* PrototypeFactory */
{
    private $sources = [
        'collections' => []
    ];

    /** @var PostRepository */
    private $postRepository;

    /** @var ProfileRepository */
    private $profileRepository;

    public function __construct(PostRepository $postRepository, ProfileRepository $profileRepository) {
        $this->postRepository = $postRepository;
        $this->profileRepository = $profileRepository;
    }

    public function getCollectionSourcePrototype(int $collectionId): CollectionSource {
        if(! isset($this->sources['collections'][$collectionId])) {
            $this->sources['collections'][$collectionId] = new CollectionSource($collectionId, $this->postRepository);
        }

        return $this->sources['collections'][$collectionId];
    }
    
    public function getResultSetFormatter() {
        return new ResultSetFormatter($this->profileRepository);
    }
}