<?php
namespace CASS\Domain\Post\Parameters;

class CreatePostParameters
{
    /** @var int */
    private $postTypeCode;

    /** @var int */
    private $profileId;

    /** @var int */
    private $collectionId;

    /** @var string */
    private $content;

    /** @var int[] */
    private $attachmentIds;

    public function __construct(
        int $postTypeCode,
        int $profileId,
        int $collectionId,
        string $content,
        array $attachmentIds
    ) {
        $this->postTypeCode = $postTypeCode;
        $this->profileId = $profileId;
        $this->collectionId = $collectionId;
        $this->content = $content;
        $this->attachmentIds = $attachmentIds;
    }

    public function getPostTypeCode(): int
    {
        return $this->postTypeCode;
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

    public function getAttachmentIds(): array {
        return $this->attachmentIds;
    }
}
