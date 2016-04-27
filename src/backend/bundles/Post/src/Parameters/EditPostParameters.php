<?php
namespace Post\Parameters;

class EditPostParameters
{
    /** @var int */
    private $postId;
    
    /** @var int */
    private $collectionId;
    
    /** @var string */
    private $content;

    public function __construct(int $postId, int $collectionId, string $content) {
        $this->postId = $postId;
        $this->collectionId = $collectionId;
        $this->content = $content;
    }

    public function getPostId(): int {
        return $this->postId;
    }

    public function getCollectionId(): int {
        return $this->collectionId;
    }

    public function getContent(): string {
        return $this->content;
    }
}