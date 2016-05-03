<?php
namespace Feed\Feed\Source\Collection;

use Feed\Feed\Criteria;
use Feed\Feed\CriteriaRequest;
use Feed\Feed\Query;
use Feed\Feed\ResultSet;
use Post\Repository\PostRepository;

final class CollectionQuery implements Query
{
    /** @var int */
    private $collectionId;

    /** @var CriteriaRequest */
    private $criteriaRequest;

    /** @var PostRepository */
    private $postRepository;

    public function __construct(int $collectionId, CriteriaRequest $criteriaRequest, PostRepository $postRepository) {
        $this->collectionId = $collectionId;
        $this->criteriaRequest = $criteriaRequest;
        $this->postRepository = $postRepository;
    }

    public function execute() {
        return new ResultSet($this->postRepository->getFeed($this->collectionId, $this->criteriaRequest));
    }
}