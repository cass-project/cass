<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
use ZEA2\Platform\Bundles\PHPUnit\RESTRequest\RESTRequest;

/**
 * @backupGlobals disabled
 */
class SubscribeMiddlewareTestCase extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new SampleThemesFixture()
        ];
    }

    protected function requestSubscribeTheme(int $themeId): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/subscribe/subscribe-theme/%s', $themeId));
    }

}