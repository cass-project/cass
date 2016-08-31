<?php
namespace ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations;

class ExpectId
{
    public function __toString(): string
    {
        return "{{ID}}";
    }
}