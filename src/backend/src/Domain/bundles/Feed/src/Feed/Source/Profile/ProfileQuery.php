<?php


namespace Domain\Feed\Feed\Source\Profile;


use Domain\Feed\Feed\CriteriaRequest;
use Domain\Feed\Feed\Query;
use Domain\Feed\Feed\ResultSet;
use Domain\Post\Repository\PostRepository;

final class ProfileQuery implements Query
{
    /** @var int */
    private $profileId;

    /** @var CriteriaRequest */
    private $criteriaRequest;

    /** @var PostRepository */
    private $postRepository;

    public function __construct(int $profileId, CriteriaRequest $criteriaRequest, PostRepository $postRepository) {
        $this->profileId = $profileId;
        $this->criteriaRequest = $criteriaRequest;
        $this->postRepository = $postRepository;
    }

    public function execute() /* ResultSet || array ! */{
        return new ResultSet(
            $this->postRepository->getProfileFeed($this->profileId, $this->criteriaRequest),
            $this->postRepository->getProfileFeedTotal($this->profileId, $this->criteriaRequest)
        );
    }

}