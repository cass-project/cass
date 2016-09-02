<?php
namespace  CASS\Application\Bundles\PHPUnit\TestCase\Expectations;

use ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations\Expectation;
use ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations\ExpectationParams;

class ExpectImageCollection implements Expectation
{
    public function __toString(): string
    {
        return "{{IMAGE_COLLECTION}}";
    }

    public function expect(ExpectationParams $params)
    {
        $case = $params->getCase();
        $key = $params->getKey();
        $actual = $params->getActual();

        $case->assertArrayHasKey($key, $actual);

        $case->recursiveAssertEquals([
            'uid' => $case->expectString(),
            'is_auto_generated' => function($input) use ($case) {
                $case->assertTrue(is_bool($input));
            },
            'variants' => [
                'default' => [
                    'id' => 'default',
                    'public_path' => $case->expectString(),
                    'storage_path' => $case->expectString(),
                ]
            ]
        ], $actual[$key], $params->getLevel() . '- ');
    }
}