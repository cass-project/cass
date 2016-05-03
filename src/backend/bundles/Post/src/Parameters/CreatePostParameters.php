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
    
    /** @var LinkParameters[] */
    private $links;

    /** @var int[] */
    private $attachmentIds;

    public function __construct(int $profileId, int $collectionId, string $content, array $links, array $attachmentIds) {
        $this->profileId = $profileId;
        $this->collectionId = $collectionId;
        $this->content = $content;
        $this->links = $links;
        $this->attachmentIds = $attachmentIds;
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

    /** @return LinkParameters[] */
    public function getLinks(): array {
        return $this->links;
    }

    public function getAttachmentIds(): array {
        return $this->attachmentIds;
    }
}
