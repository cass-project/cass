<?php
namespace Domain\Feedback\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Feedback\Tests\FeedbackMiddlewareTest;
use Domain\Feedback\Tests\Fixture\DemoFeedbackFixture;

/**
 * @backupGlobals disabled
 */
class FeedbackGetByIdMiddlewareTest extends FeedbackMiddlewareTest
{
    public function testGetFeedbackById403()
    {
        $this->requestGetById(DemoFeedbackFixture::getFeedback(1)->getId())
            ->execute()
            ->expectAuthError();
    }

    public function testGetFeedbackById404()
    {
        $this->requestGetById(9999999)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testGetFeedbackById200()
    {
        $feedback = DemoFeedbackFixture::getFeedback(1);

        $this->requestGetById($feedback->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => $feedback->toJSON()
            ]);
    }
}