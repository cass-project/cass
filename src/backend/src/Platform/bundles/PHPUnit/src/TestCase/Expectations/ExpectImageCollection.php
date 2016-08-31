<?php
namespace ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations;

class ExpectImageCollection
{
    public function __toString(): string
    {
        return "{{IMAGE_COLLECTION}}";
    }
}