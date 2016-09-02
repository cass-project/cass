<?php
namespace CASS\Domain\Account\Tests\REST\Paths;

use CASS\Domain\Account\Tests\AccountMiddlewareTestCase;
use CASS\Domain\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Account\Tests\Fixtures\DemoAdminAccountsFixture;

/**
 * @backupGlobals disabled
 */
final class AppAccessMiddlewareTest extends AccountMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture()
        ];
    }
    
    public function testAppAccess403()
    {
        $this->requestAppAccess()
            ->execute()
            ->expectAuthError();
    }

    public function testAppAccessDefaults200()
    {
        $account = DemoAccountFixture::getAccount();

        $this->requestAppAccess()
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'access' => [
                    'apps' => [
                        'admin' => false,
                        'feedback' => false,
                        'reports' => false
                    ],
                    'account' => $account->toJSON()
                ]
            ]);
    }

    public function testAppAccessHasAllAccess200()
    {
        $this->upFixture(new DemoAdminAccountsFixture());

        $account = DemoAdminAccountsFixture::getAllAccount();

        $this->requestAppAccess()
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'access' => [
                    'apps' => [
                        'admin' => true,
                        'feedback' => true,
                        'reports' => true,
                    ],
                    'account' => $account->toJSON()
                ]
            ]);
    }

    public function testAppAccessHasAdminAccess200()
    {
        $this->upFixture(new DemoAdminAccountsFixture());

        $account = DemoAdminAccountsFixture::getAdminAccount();

        $this->requestAppAccess()
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'access' => [
                    'apps' => [
                        'admin' => true,
                        'feedback' => false,
                        'reports' => false,
                    ],
                    'account' => $account->toJSON()
                ]
            ]);
    }

    public function testAppAccessHasReportsAccess200()
    {
        $this->upFixture(new DemoAdminAccountsFixture());

        $account = DemoAdminAccountsFixture::getReportsAccount();

        $this->requestAppAccess()
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'access' => [
                    'apps' => [
                        'admin' => false,
                        'feedback' => false,
                        'reports' => true,
                    ],
                    'account' => $account->toJSON()
                ]
            ]);
    }

    public function testAppAccessHasFeedbackAccess200()
    {
        $this->upFixture(new DemoAdminAccountsFixture());

        $account = DemoAdminAccountsFixture::getFeedbackAccount();

        $this->requestAppAccess()
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'access' => [
                    'apps' => [
                        'admin' => false,
                        'feedback' => true,
                        'reports' => false,
                    ],
                    'account' => $account->toJSON()
                ]
            ]);
    }
}