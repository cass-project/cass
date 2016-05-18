<?php
namespace Domain\Community\Tests;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class CommunityFeatureMiddlewareTest extends CommunityMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
            new SampleCommunitiesFixture()
        ];
    }

    public function testActivateFeature403()
    {
        
    }

    public function testActivateFeature404()
    {

    }

    public function testActivateFeature409()
    {

    }

    public function testActivateFeature200()
    {

    }

    public function testDeactivateFeature403()
    {

    }

    public function testDeactivateFeature404()
    {

    }

    public function testDeactivateFeature409()
    {

    }

    public function testDeactivateFeature200()
    {

    }

    public function testIsFeatureActivated403()
    {

    }

    public function testIsFeatureActivated404()
    {

    }

    public function testIsFeatureActivated200()
    {

    }
}