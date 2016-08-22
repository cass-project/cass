<?php
namespace Application\PHPUnit\TestCase\Expectations;

class ExpectString
{
    public function __toString(): string
    {
        return "{{STRING}}";
    }
}