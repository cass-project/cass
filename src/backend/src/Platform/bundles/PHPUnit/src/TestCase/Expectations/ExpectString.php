<?php
namespace ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations;

class ExpectString implements Expectation
{
    public function __toString(): string
    {
        return "{{STRING}}";
    }

    public function expect(ExpectationParams $params)
    {
        $case = $params->getCase();
        $key = $params->getKey();
        $actual = $params->getActual();

        $case->assertArrayHasKey($key, $actual);
        $case->assertTrue(is_string($actual[$key]));
    }
}