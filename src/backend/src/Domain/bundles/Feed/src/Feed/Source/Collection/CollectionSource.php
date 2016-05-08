<?php
namespace Domain\Feed\Feed\Source\Collection;

use Domain\Feed\Feed\CriteriaRequest;
use Domain\Feed\Feed\Query;
use Domain\Feed\Feed\Source;
use Domain\Post\Repository\PostRepository;

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