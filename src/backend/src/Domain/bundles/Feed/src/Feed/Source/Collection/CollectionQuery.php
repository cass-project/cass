<?php
namespace Domain\Feed\Feed\Source\Collection;

use Domain\Feed\Feed\Criteria;
use Domain\Feed\Feed\CriteriaRequest;
use Domain\Feed\Feed\Query;
use Domain\Feed\Feed\ResultSet;
use Domain\Post\Repository\PostRepository;

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
        return new ResultSet(
            $this->postRepository->getFeed($this->collectionId, $this->criteriaRequest),
            $this->postRepository->getFeedTotal($this->collectionId, $this->criteriaRequest)
        );
    }
}