<?php


namespace Domain\Feed\Feed\Source\Community;


use Domain\Feed\Feed\CriteriaRequest;
use Domain\Feed\Feed\Query;
use Domain\Feed\Feed\ResultSet;
use Domain\Post\Repository\PostRepository;

class CommunityQuery implements Query
{
    private $communityId;
    private $criteriaRequest;
    private $postRepository;

    public function __construct(int $communityId, CriteriaRequest $criterisRequest, PostRepository $postRepository)
    {
        $this->communityId = $communityId;
        $this->criteriaRequest = $criterisRequest;
        $this->postRepository = $postRepository;
    }

    public function execute():ResultSet /* ResultSet || array ! */
    {
        return new ResultSet(
            $this->postRepository->getCommunityFeed($this->communityId,$this->criteriaRequest),
            $this->postRepository->getCommunityFeedTotal($this->communityId, $this->criteriaRequest)
        );
    }

}