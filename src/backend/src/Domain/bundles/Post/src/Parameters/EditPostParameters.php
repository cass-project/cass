<?php
namespace Domain\Post\Parameters;

class EditPostParameters
{
    /** @var int */
    private $postId;
    
    /** @var string */
    private $content;

    public function __construct(int $postId, string $content) {
        $this->postId = $postId;
        $this->content = $content;
    }

    public function getPostId(): int {
        return $this->postId;
    }

    public function getContent(): string {
        return $this->content;
    }
}