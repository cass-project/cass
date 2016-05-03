<?php
namespace Feed\Feed\Source\Collection;

use Feed\Feed\CriteriaRequest;
use Feed\Feed\Query;
use Feed\Feed\Source;
use Post\Repository\PostRepository;

final class CollectionSource implements Source
{
    /** @var int */
    private $collectionId;

    /** @var PostRepository */
    private $postRepository;

    public function __construct($collectionId, PostRepository $postRepository) {
        $this->collectionId = $collectionId;
        $this->postRepository = $postRepository;
    }

    public function createQuery(CriteriaRequest $criteriaRequest): Query {
        return new CollectionQuery($this->collectionId, $criteriaRequest, $this->postRepository);
    }
}