<?php


namespace Domain\Feed\Feed\Source\Community;


use Domain\Feed\Feed\CriteriaRequest;
use Domain\Feed\Feed\Query;
use Domain\Feed\Feed\Source;
use Domain\Post\Repository\PostRepository;

final class CommunitySource implements Source
{
    protected $communityId;
    protected $postRepository;

    public function __construct(int $communityId, PostRepository $postRepository)
    {
        $this->communityId = $communityId;
        $this->postRepository = $postRepository;
    }

    public function createQuery(CriteriaRequest $criteriaRequest): Query
    {
        return new CommunityQuery($this->communityId, $criteriaRequest, $this->postRepository);
    }
}