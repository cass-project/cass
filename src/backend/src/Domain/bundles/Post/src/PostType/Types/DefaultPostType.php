<?php
namespace CASS\Domain\Bundles\Post\PostType\Types;

final class DefaultPostType extends AbstractPostType
{
    const CODE_INT = 0;
    const CODE_STRING = 'default';

    public function getIntCode(): int
    {
        return self::CODE_INT;
    }

    public function getStringCode(): string
    {
        return self::CODE_STRING;
    }
}