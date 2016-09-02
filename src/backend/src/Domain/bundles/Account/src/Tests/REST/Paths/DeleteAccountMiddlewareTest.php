<?php
namespace CASS\Domain\Bundles\Account\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\AccountMiddlewareTestCase;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;

/**
 * @backupGlobals disabled
 */
final class DeleteAccountMiddlewareTest extends AccountMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture()
        ];
    }

    public function testDeleteRequest403()
    {
        $this->requestDeleteRequest()
            ->execute()
            ->expectAuthError();
    }

    public function testDeleteRequest200()
    {
        $this->requestDeleteRequest()
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'date_account_delete_request' => $this->expectString()
            ]);
    }

    public function testDeleteRequest409()
    {
        $this->requestDeleteRequest()
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute();

        $this->requestDeleteRequest()
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString()
            ]);
    }
}