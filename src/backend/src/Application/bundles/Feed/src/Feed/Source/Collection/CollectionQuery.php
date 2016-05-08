<?php
namespace Application\Feed\Feed\Source\Collection;

use Application\Feed\Feed\Criteria;
use Application\Feed\Feed\CriteriaRequest;
use Application\Feed\Feed\Query;
use Application\Feed\Feed\ResultSet;
use Application\Post\Repository\PostRepository;

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