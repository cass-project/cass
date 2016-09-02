<?php
namespace ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations;

interface Expectation
{
    public function __toString(): string;
    public function expect(ExpectationParams $params);
}