<?php
namespace Domain\Contact\Tests;

use ZEA2\Platform\Bundles\PHPUnit\RESTRequest\RESTRequest;
use ZEA2\Platform\Bundles\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Contact\Tests\Fixture\DemoContactFixture;

/**
 * @backupGlobals disabled
 */
abstract class ContactMiddlewareTest extends MiddlewareTestCase
{
    /** @var DemoContactFixture */
    private $fixture;

    protected function getFixtures(): array
    {
        if(! $this->fixture) {
            $this->fixture = new DemoContactFixture();
        }

        return [
            $this->fixture,
        ];
    }

    protected function getFixture()
    {
        return $this->fixture;
    }

    protected function requestCreateContact(int $profileId, array $json): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/profile/%s/contact/create', $profileId))
            ->setParameters($json);
    }

    protected function requestDeleteContact(int $profileId, int $contactId): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/profile/%s/contact/%s/delete', $profileId, $contactId));
    }

    protected function requestGetContact(int $profileId, int $contactId): RESTRequest
    {
        return $this->request('GET', sprintf('/protected/profile/%s/contact/%s/get', $profileId, $contactId));
    }

    protected function requestListContacts(int $profileId): RESTRequest
    {
        return $this->request('GET', sprintf('/protected/profile/%s/contact/list', $profileId));
    }

    protected function requestContactSetPermanent(int $profileId, int $contactId): RESTRequest
    {
        return $this->request('POST', sprintf('/protected/profile/%s/contact/%s/set-permanent', $profileId, $contactId));
    }
}