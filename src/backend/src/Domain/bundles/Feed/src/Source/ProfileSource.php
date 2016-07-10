<?php
namespace Domain\Feed\Source;

use Domain\Feed\Service\Entity;
use Domain\Post\Entity\Post;

final class ProfileSource implements Source
{
    /** @var int */
    private $profileId;

    public function __construct(int $profileId)
    {
        $this->profileId = $profileId;
    }

    public function getMongoDBCollection(): string
    {
        return sprintf('profile_feed_%d', $this->profileId);
    }

    public function test(Entity $entity)
    {
        /** @var Post $entity */
        
        return
            ($testIsPostEntity = $entity instanceof Post)
         && ($testIsOwnedByProfile = $entity->getAuthorProfile()->getId() === $this->profileId)
        ;
    }
}