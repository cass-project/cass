<?php
namespace Application\PHPUnit\TestCase\Expectations;

class ExpectId
{
    public function __toString(): string
    {
        return "{{ID}}";
    }
}