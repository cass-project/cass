<?php
namespace CASS\Domain\Bundles\Post\PostType;

use CASS\Util\JSONSerializable;

interface PostType extends JSONSerializable
{
    public function getIntCode(): int;
    public function getStringCode(): string;
}