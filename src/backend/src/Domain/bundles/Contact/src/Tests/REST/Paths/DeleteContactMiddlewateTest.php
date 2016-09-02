<?php
namespace CASS\Domain\Bundles\Contact\Tests\REST\Paths;

use CASS\Domain\Bundles\Contact\Tests\ContactMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class DeleteContactMiddlewareTest extends ContactMiddlewareTest
{
    public function testDelete403NotAuth()
    {
        $fixture = $this->getFixture();

        $sourceId = $fixture->getProfile_A1_P1()->getId();
        $contactId = $fixture->getContact_A1_P1_C1()->getId();

        $this->requestDeleteContact($sourceId, $contactId)
            ->execute()
            ->expectAuthError();
    }

    public function testDelete404ProfileNotFound()
    {
        $fixture = $this->getFixture();

        $account = $fixture->getAccount_A1();
        $sourceId = self::NOT_FOUND_ID;
        $contactId = $fixture->getContact_A1_P1_C1()->getId();

        $this->requestDeleteContact($sourceId, $contactId)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testDelete404ContactNotFound()
    {
        $fixture = $this->getFixture();

        $account = $fixture->getAccount_A1();
        $sourceId = $fixture->getProfile_A1_P1()->getId();
        $contactId = self::NOT_FOUND_ID;

        $this->requestDeleteContact($sourceId, $contactId)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testDelete200Success()
    {
        $fixture = $this->getFixture();

        $account = $fixture->getAccount_A1();
        $sourceId = $fixture->getProfile_A1_P1()->getId();
        $contactId = $fixture->getContact_A1_P1_C1()->getId();

        $this->requestDeleteContact($sourceId, $contactId)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ]);
    }
}