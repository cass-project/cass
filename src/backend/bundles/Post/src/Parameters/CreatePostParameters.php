<?php
namespace Post\Parameters;

class CreatePostParameters
{
    /** @var int */
    private $profileId;

    /** @var int */
    private $collectionId;

    /** @var string */
    private $content;
    
    public function __construct(int $profileId, int $collectionId, string $content) {
        $this->profileId = $profileId;
        $this->collectionId = $collectionId;
        $this->content = $content;
    }

    public function getProfileId(): int {
        return $this->profileId;
    }

    public function getCollectionId(): int {
        return $this->collectionId;
    }

    public function getContent(): string {
        return $this->content;
    }
}