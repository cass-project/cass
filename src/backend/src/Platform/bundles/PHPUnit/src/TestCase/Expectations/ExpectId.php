<?php
namespace ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations;

class ExpectId implements Expectation
{
    public function __toString(): string
    {
        return "{{ID}}";
    }

    public function expect(ExpectationParams $params)
    {
        $case = $params->getCase();
        $key = $params->getKey();
        $actual = $params->getActual();

        $case->assertArrayHasKey($key, $actual);
        $case->assertTrue(is_int($actual[$key]));
        $case->assertGreaterThan(0, $actual[$key]);
    }
}