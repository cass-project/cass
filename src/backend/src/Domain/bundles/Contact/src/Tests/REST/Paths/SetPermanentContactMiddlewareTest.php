<?php
namespace Domain\Contact\Tests\REST\Paths;

use Domain\Contact\Tests\ContactMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class SetPermanentContactMiddlewareTest extends ContactMiddlewareTest
{
    public function testSetPermanent403NotAuth()
    {
        $fixture = $this->getFixture();

        $sourceId = $fixture->getProfile_A1_P1()->getId();
        $contactId = $fixture->getContact_A1_P1_C1()->getId();

        $this->requestContactSetPermanent($sourceId, $contactId)
            ->execute()
            ->expectAuthError();
    }

    public function testSetPermanent404ProfileNotFound()
    {
        $fixture = $this->getFixture();

        $account = $fixture->getAccount_A1();
        $sourceId = self::NOT_FOUND_ID;
        $contactId = $fixture->getContact_A1_P1_C1()->getId();

        $this->requestContactSetPermanent($sourceId, $contactId)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testSetPermanent404ContactNotFound()
    {
        $fixture = $this->getFixture();

        $account = $fixture->getAccount_A1();
        $sourceId = $fixture->getProfile_A1_P1()->getId();
        $contactId = self::NOT_FOUND_ID;

        $this->requestContactSetPermanent($sourceId, $contactId)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testSetPermanent200Success()
    {
        $fixture = $this->getFixture();

        $account = $fixture->getAccount_A1();
        $sourceId = $fixture->getProfile_A1_P1()->getId();
        $contactId = $fixture->getContact_A1_P1_C1()->getId();

        $this->requestContactSetPermanent($sourceId, $contactId)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $contactId,
                    'permanent' => [
                        'is' => 1,
                        'date' => $this->expectString()
                    ]
                ]
            ]);
    }
}