<?php
namespace Domain\Feed\Service;

use Domain\Feed\Feed\Source\Collection\CollectionSource;
use Domain\Feed\Feed\Source\Community\CommunitySource;
use Domain\Feed\Formatter\ResultSetFormatter;
use Domain\Post\Repository\PostRepository;
use Domain\Profile\Repository\ProfileRepository;

class FeedSourcesService /* PrototypeFactory */
{
    private $sources = [
        'collections' => [],
        'communities' => []
    ];

    /** @var PostRepository */
    private $postRepository;

    /** @var ProfileRepository */
    private $profileRepository;

    public function __construct(PostRepository $postRepository, ProfileRepository $profileRepository){
        $this->postRepository    = $postRepository;
        $this->profileRepository = $profileRepository;
    }

    public function getCollectionSourcePrototype(int $collectionId): CollectionSource
    {
        if(!isset($this->sources['collections'][$collectionId])){
            $this->sources['collections'][$collectionId] = new CollectionSource($collectionId, $this->postRepository);
        }

        return $this->sources['collections'][$collectionId];
    }

    public function getCommunitySourcePrototype(int $communityId): CommunitySource
    {
        if( !isset($this->sources['communities'][$communityId])){
            $this->sources['communities'][$communityId] = new CommunitySource($communityId, $this->postRepository);
        }
        return $this->sources['communities'][$communityId];
    }
    
    public function getResultSetFormatter() {
        return new ResultSetFormatter($this->profileRepository);
    }
}