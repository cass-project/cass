<?php
namespace Domain\ProfileCommunities\Tests;

use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class ProfileCommunitiesAPITest extends MiddlewareTestCase
{
    protected function getFixtures(): array {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
            new SampleCommunitiesFixture(),
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