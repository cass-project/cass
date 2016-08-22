<?php
namespace Application\PHPUnit\TestCase\Expectations;

class ExpectUndefined
{
    public function __toString(): string
    {
        return "{{UNDEFINED}}";
    }
}