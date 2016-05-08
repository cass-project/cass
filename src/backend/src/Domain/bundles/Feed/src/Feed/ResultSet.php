<?php
namespace Domain\Feed\Feed;

use Domain\Post\Entity\Post;

class ResultSet
{
    /** @var Post[] */
    private $posts;

    /** @var int */
    private $total;

    public function __construct(array $posts, int $total) {
        $this->posts = $posts;
        $this->total = $total;
    }

    /** @return \Domain\Post\Entity\Post[] */
    public function getPosts(): array {
        return $this->posts;
    }

    public function getTotal(): int {
        return $this->total;
    }
}