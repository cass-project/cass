<?php
namespace Domain\Profile\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;

abstract class ProfileMiddlewareTestCase extends MiddlewareTestCase
{
    protected function getFixtures(): array {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture()
        ];
    }

    protected function requestCreateProfile(): RESTRequest {
        return $this->request('PUT', sprintf('/protected/profile/create'));
    }

    protected function requestGetProfile(int $profileId): RESTRequest {
        return $this->request('GET', sprintf('/profile/%d/get', $profileId));
    }

    protected function requestDeleteProfile(int $profileId): RESTRequest {
        return $this->request('DELETE', sprintf('/protected/profile/%d/delete', $profileId));
    }
}