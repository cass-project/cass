<?php
namespace Domain\Community\Tests;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Application\PHPUnit\TestCase\MiddlewareTestCase;

class CommunityAPITests extends MiddlewareTestCase
{
    protected function getFixtures(): array {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture()
        ];
    }
}