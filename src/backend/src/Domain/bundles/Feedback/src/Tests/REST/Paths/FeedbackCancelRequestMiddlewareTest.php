<?php
namespace CASS\Domain\Bundles\Feedback\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Feedback\Tests\FeedbackMiddlewareTest;
use CASS\Domain\Bundles\Feedback\Tests\Fixture\DemoFeedbackFixture;

/**
 * @backupGlobals disabled
 */
class FeedbackCancelRequestMiddlewareTest extends FeedbackMiddlewareTest
{
    public function testFeedbackCancel403()
    {
        $feedbackId = DemoFeedbackFixture::getFeedback(1)->getId();

        $this->requestFeedbackDelete($feedbackId)
            ->execute()
            ->expectAuthError();
    }


    public function testFeedbackCancel404()
    {
        $this->requestFeedbackDelete(9999999)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectNotFoundError();
    }

    public function testFeedbackCancel200()
    {
        $feedbackId = DemoFeedbackFixture::getFeedback(1)->getId();

        $this->requestFeedbackDelete($feedbackId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true
            ]);
    }
}