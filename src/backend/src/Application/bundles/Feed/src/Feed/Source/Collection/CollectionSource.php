<?php
namespace Application\Feed\Feed\Source\Collection;

use Application\Feed\Feed\CriteriaRequest;
use Application\Feed\Feed\Query;
use Application\Feed\Feed\Source;
use Application\Post\Repository\PostRepository;

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