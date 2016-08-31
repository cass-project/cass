<?php
namespace ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations;

class ExpectString
{
    public function __toString(): string
    {
        return "{{STRING}}";
    }
}