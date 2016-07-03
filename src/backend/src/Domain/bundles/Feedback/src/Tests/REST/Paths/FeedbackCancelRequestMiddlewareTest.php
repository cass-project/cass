<?php
namespace Domain\Feedback\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Feedback\Tests\FeedbackMiddlewareTest;
use Domain\Feedback\Tests\Fixture\DemoFeedbackFixture;

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