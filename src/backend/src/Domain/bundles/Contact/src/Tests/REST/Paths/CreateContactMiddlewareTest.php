<?php
namespace CASS\Domain\Bundles\Contact\Tests\REST\Paths;

use CASS\Domain\Bundles\Contact\Tests\ContactMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class CreateContactMiddlewareTest extends ContactMiddlewareTest
{
    public function testCreate403NotAuth()
    {
        $fixture = $this->getFixture();

        $sourceProfile = $fixture->getProfile_A3_P1();
        $targetProfile = $fixture->getProfile_A1_P1();
        
        $this->requestCreateContact($sourceProfile->getId(), ['profile_id' => $targetProfile->getId()])
            ->execute()
            ->expectAuthError();
    }

    public function testCreate404Source()
    {
        $fixture = $this->getFixture();

        $sourceAccount = $fixture->getAccount_A1();
        $sourceProfileId = self::NOT_FOUND_ID;
        $targetProfileId = $fixture->getProfile_A1_P1()->getId();

        $this->requestCreateContact($sourceProfileId, ['profile_id' => $targetProfileId])
            ->auth($sourceAccount->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testCreate404Target()
    {
        $fixture = $this->getFixture();

        $sourceAccount = $fixture->getAccount_A3();
        $sourceProfileId = $fixture->getProfile_A3_P1()->getId();
        $targetProfileId = self::NOT_FOUND_ID;

        $this->requestCreateContact($sourceProfileId, ['profile_id' => $targetProfileId])
            ->auth($sourceAccount->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testCreate200Success()
    {
        $fixture = $this->getFixture();

        $sourceAccount = $fixture->getAccount_A3();
        $sourceProfileId = $fixture->getProfile_A3_P1()->getId();
        $targetProfileId = $fixture->getProfile_A1_P1()->getId();

        $this->requestCreateContact($sourceProfileId, ['profile_id' => $targetProfileId])
            ->auth($sourceAccount->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'sid' => $this->expectString(),
                    'date_created_on' => $this->expectString(),
                    'last_message' => [
                        'has' => 1,
                        'date' => $this->expectString(),
                        'message' => $this->expectString(),
                    ],
                    'permanent' => [
                        'is' => 1,
                        'date' => $this->expectString(),
                    ],
                    'source_profile' => [
                        'id' => $sourceProfileId,
                    ],
                    'target_profile' => [
                        'id' => $targetProfileId,
                    ]
                ]
            ]);
    }

    public function testCreate409Duplicate()
    {
        $fixture = $this->getFixture();

        $sourceAccount = $fixture->getAccount_A3();
        $sourceProfileId = $fixture->getProfile_A3_P1()->getId();
        $targetProfileId = $fixture->getProfile_A1_P1()->getId();

        $this->requestCreateContact($sourceProfileId, ['profile_id' => $targetProfileId])
            ->auth($sourceAccount->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                ]
            ]);

        $this->requestCreateContact($sourceProfileId, ['profile_id' => $targetProfileId])
            ->auth($sourceAccount->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString()
            ]);
    }
}