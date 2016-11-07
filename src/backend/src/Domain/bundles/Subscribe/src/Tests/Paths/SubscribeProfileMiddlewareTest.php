<?php
namespace CASS\Domain\Bundles\Subscribe\Tests\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Tests\SubscribeMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class SubscribeProfileMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function test200()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoAccountFixture::getSecondAccount()->getCurrentProfile();

        $this->requestSubscribeProfile($profile->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'profileId' => $account->getCurrentProfile()->getId(),
                    'subscribeId' => $profile->getId(),
                    'subscribeType' => Subscribe::TYPE_PROFILE,
                ]
            ]);
    }

    public function test403()
    {
        $account = DemoAccountFixture::getAccount();

        $this->requestSubscribeProfile($account->getCurrentProfile()->getId())
            ->execute()
            ->expectAuthError();
    }

    public function test404()
    {
        $account = DemoAccountFixture::getAccount();

        $this->requestSubscribeProfile(self::NOT_FOUND_ID)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }
}