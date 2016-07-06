<?php
namespace Domain\Post\PostType;

use Application\Util\JSONSerializable;

interface PostType extends JSONSerializable
{
    public function getIntCode(): int;
    public function getStringCode(): string;
}