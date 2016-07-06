<?php
namespace Domain\Post\PostType;

use Domain\Post\Exception\UnknownPostTypeException;
use Domain\Post\PostType\Types\DefaultPostType;
use Domain\Post\PostType\Types\DiscussionPostType;

final class PostTypeFactory
{
    public function createPostTypeByIntCode(int $intCode): PostType
    {
        switch($intCode) {
            default:
                throw new UnknownPostTypeException(sprintf('Unknown post type with code `%s`', $intCode));

            case DefaultPostType::CODE_INT:
                return new DefaultPostType();

            case DiscussionPostType::CODE_INT:
                return new DiscussionPostType();
        }
    }

    public function createPostTypeByStringCode(string $stringCode): PostType
    {
        switch($stringCode) {
            default:
                throw new UnknownPostTypeException(sprintf('Unknown post type with code `%s`', $stringCode));

            case DefaultPostType::CODE_STRING:
                return new DefaultPostType();

            case DiscussionPostType::CODE_STRING:
                return new DiscussionPostType();
        }
    }
}