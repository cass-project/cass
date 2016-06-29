<?php


namespace Domain\Feed\Feed\Source\Profile;


use Domain\Feed\Feed\CriteriaRequest;
use Domain\Feed\Feed\Query;
use Domain\Feed\Feed\Source;
use Domain\Post\Repository\PostRepository;

final class ProfileSource implements Source
{
    /** @var int */
    private $profileId;

    /** @var PostRepository */
    private $postRepository;

    public function __construct($profileId, PostRepository $postRepository) {
        $this->profileId = $profileId;
        $this->postRepository = $postRepository;
    }

    public function createQuery(CriteriaRequest $criteriaRequest): Query{
        return new ProfileQuery($this->profileId, $criteriaRequest, $this->postRepository);
    }

}