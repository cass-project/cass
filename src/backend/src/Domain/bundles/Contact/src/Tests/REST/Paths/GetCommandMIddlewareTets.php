<?php
namespace CASS\Domain\Bundles\Contact\Tests\REST\Paths;

use CASS\Domain\Bundles\Contact\Tests\ContactMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class GetContactMiddlewareTest extends ContactMiddlewareTest
{
    public function testGet403NotAuth()
    {
        $fixture = $this->getFixture();

        $sourceId = $fixture->getProfile_A1_P1()->getId();
        $contactId = $fixture->getContact_A1_P1_C1()->getId();

        $this->requestGetContact($sourceId, $contactId)
            ->execute()
            ->expectAuthError();
    }

    public function testGet404ProfileNotFound()
    {
        $fixture = $this->getFixture();

        $account = $fixture->getAccount_A1();
        $sourceId = self::NOT_FOUND_ID;
        $contactId = $fixture->getContact_A1_P1_C1()->getId();

        $this->requestGetContact($sourceId, $contactId)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testGet404ContactNotFound()
    {
        $fixture = $this->getFixture();

        $account = $fixture->getAccount_A1();
        $sourceId = $fixture->getProfile_A1_P1()->getId();
        $contactId = self::NOT_FOUND_ID;

        $this->requestGetContact($sourceId, $contactId)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testGet200Success()
    {
        $fixture = $this->getFixture();

        $account = $fixture->getAccount_A1();
        $sourceId = $fixture->getProfile_A1_P1()->getId();
        $contactId = $fixture->getContact_A1_P1_C1()->getId();

        $this->requestGetContact($sourceId, $contactId)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => $fixture->getContact_A1_P1_C1()->toJSON()
            ]);
    }
}