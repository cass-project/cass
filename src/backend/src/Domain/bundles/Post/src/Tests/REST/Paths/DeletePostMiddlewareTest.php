<?php
namespace CASS\Domain\Bundles\Post\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Post\Tests\Fixtures\SamplePostsFixture;
use CASS\Domain\Bundles\Post\Tests\PostMiddlewareTest;

/**
 * @backupGlobals disabled
 */
class DeletePostMiddlewareTest extends PostMiddlewareTest
{
    public function testDeletePost200() {
        $this->upFixture(new SamplePostsFixture());

        $account = DemoAccountFixture::getAccount();

        $this->requestPostDelete(SamplePostsFixture::getPost(1)->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true
            ]);
    }

    public function testDeletePost403()
    {
        $this->upFixture(new SamplePostsFixture());

        $this->requestPostDelete(SamplePostsFixture::getPost(1)->getId())
            ->execute()
            ->expectAuthError();
    }

    public function testDeletePost404() {

        $account = DemoAccountFixture::getAccount();

        $this->requestPostDelete(99999999)->auth($account->getAPIKey())->execute()
            ->expectJSONContentType()
            ->expectStatusCode(404)
            ->expectJSONBody(['success' => false]);
    }
}