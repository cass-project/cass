<?php
namespace Domain\Theme\Tests;

use Application\PHPUnit\Fixtures\DemoAccountFixture;
use Application\PHPUnit\Fixtures\DemoProfileFixture;
use Application\PHPUnit\TestCase\MiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class ThemeMiddlewareTest extends MiddlewareTestCase
{
    protected function getFixtures(): array {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture()
        ];
    }

    public function testDemo() {
        $this->assertEquals(1, 1);
    }
}