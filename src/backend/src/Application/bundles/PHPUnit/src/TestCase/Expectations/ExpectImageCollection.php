<?php
namespace CASS\Application\PHPUnit\TestCase\Expectations;

class ExpectImageCollection
{
    public function __toString(): string
    {
        return "{{IMAGE_COLLECTION}}";
    }
}