<?php
namespace Feed\Feed;

use Post\Entity\Post;

class ResultSet
{
    /** @var Post[] */
    private $posts;

    public function __construct(array $posts) {
        $this->posts = $posts;
    }

    /** @return \Post\Entity\Post[] */
    public function getPosts() {
        return $this->posts;
    }
}