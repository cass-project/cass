<?php
namespace ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations;

class ExpectUndefined
{
    public function __toString(): string
    {
        return "{{UNDEFINED}}";
    }
}