<?php
namespace Application\Frontline\Tests;

use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\ProfileCommunities\Tests\Fixtures\SamplePCBookmarksFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class IsFrontlineAliveTest extends MiddlewareTestCase
{
    protected function getFixtures(): array {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
            new SampleCommunitiesFixture(),
            new SamplePCBookmarksFixture(),
        ];
    }

    public function testNoExceptionsPlease() {
        $this->request('GET', '/frontline')->execute();
    }
}