<?php
namespace Domain\ProfileCommunities\Tests;

use Application\PHPUnit\Fixtures\DemoAccountFixture;
use Application\PHPUnit\Fixtures\DemoProfileFixture;
use Application\PHPUnit\TestCase\MiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class ProfileCommunitiesAPITest extends MiddlewareTestCase
{
    protected function getFixtures(): array {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
        ];
    }

    public function testJoinCommunity() {
        // TODO:: Написать юнит-тест
    }

    public function testLeaveCommunity() {
        // TODO:: Написать юнит-тест
    }

    public function testListCommunities() {
        // TODO:: Написать юнит-тест
    }
}