<?php
namespace CASS\Domain\Post\PostType\Types;

use CASS\Domain\Post\PostType\PostType;

abstract class AbstractPostType implements PostType
{
    public function toJSON(): array
    {
        return [
            'int' => $this->getIntCode(),
            'string' => $this->getStringCode(),
        ];
    }
}