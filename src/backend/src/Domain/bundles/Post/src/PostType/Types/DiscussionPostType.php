<?php
namespace Domain\Post\PostType\Types;

final class DiscussionPostType extends AbstractPostType
{
    const CODE_INT = 1;
    const CODE_STRING = 'discussion';
    
    public function getIntCode(): int
    {
        return self::CODE_INT;
    }

    public function getStringCode(): string
    {
        return self::CODE_STRING;
    }
}