<?php
namespace CASS\Domain\IM\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use CASS\Domain\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Theme\Tests\Fixtures\SampleThemesFixture;

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