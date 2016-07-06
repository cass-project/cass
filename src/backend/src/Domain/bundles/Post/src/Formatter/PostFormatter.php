<?php
namespace Domain\Post\Formatter;

use Domain\Post\Entity\Post;
use Domain\Post\PostType\PostTypeFactory;

final class PostFormatter
{
    /** @var PostTypeFactory */
    private $postTypeFactory;
    
    public function __construct(PostTypeFactory $postTypeFactory)
    {
        $this->postTypeFactory = $postTypeFactory;
    }

    public function format(Post $post): array 
    {
        $postTypeObject = $this->postTypeFactory->createPostTypeByIntCode($post->getPostTypeCode());
        
        return array_merge($post->toJSON(), [
            'post_type' => $postTypeObject->toJSON(),
            'attachments' => []
        ]);
    }
}