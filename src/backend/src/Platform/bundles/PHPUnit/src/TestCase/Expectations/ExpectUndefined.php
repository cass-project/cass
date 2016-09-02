<?php
namespace ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations;

class ExpectUndefined implements Expectation
{
    public function __toString(): string
    {
        return "{{UNDEFINED}}";
    }

    public function expect(ExpectationParams $params)
    {
        $case = $params->getCase();
        $key = $params->getKey();
        $actual = $params->getActual();

        $case->assertArrayNotHasKey($key, $actual);
    }
}