<?php
namespace CASS\Domain\Bundles\IM\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
abstract class IMMiddlewareTest extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
            new SampleCommunitiesFixture(),
        ];
    }

    protected function requestSend(int $sourceProfileId, string $source, int $sourceId, array $json)
    {
        return $this->request('PUT', sprintf('/protected/with-profile/%s/im/send/to/%s/%s', $sourceProfileId, $source, $sourceId))
            ->setParameters($json);
    }

    protected function requestMessages(int $targetProfileId, string $source, int $sourceId, array $json)
    {
        return $this->request('POST', sprintf('/protected/with-profile/%s/im/messages/%s/%s', $targetProfileId, $source, $sourceId))
            ->setParameters($json);
    }

    protected function requestUnread(int $targetProfileId)
    {
        return $this->request('GET', sprintf('/protected/with-profile/%s/im/unread/', $targetProfileId));
    }
}