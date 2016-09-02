<?php
namespace CASS\Domain\Bundles\Contact\Tests\REST\Paths;

use CASS\Domain\Bundles\Contact\Tests\ContactMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class ListContactMiddlewareTest extends ContactMiddlewareTest
{
    public function testList403NotAuth()
    {
        $fixture = $this->getFixture();

        $sourceId = $fixture->getProfile_A1_P1()->getId();

        $this->requestListContacts($sourceId)
            ->execute()
            ->expectAuthError();
    }

    public function testList404ProfileNotFound()
    {
        $fixture = $this->getFixture();

        $account = $fixture->getAccount_A1();
        $sourceId = self::NOT_FOUND_ID;

        $this->requestListContacts($sourceId)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testList200Success()
    {
        $fixture = $this->getFixture();

        $account = $fixture->getAccount_A1();
        $sourceId = $fixture->getProfile_A1_P1()->getId();

        $this->requestListContacts($sourceId)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entities' => [
                    0 => $fixture->getContact_A1_P1_C1()->toJSON(),
                    1 => $fixture->getContact_A1_P1_C2()->toJSON(),
                ]
            ]);
    }
}