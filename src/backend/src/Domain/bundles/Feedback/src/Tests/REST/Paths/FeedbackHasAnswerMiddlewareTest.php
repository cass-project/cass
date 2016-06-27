<?php
namespace Domain\Feedback\Tests\REST\Paths;

use Domain\Feedback\Tests\FeedbackMiddlewareTest;
use Domain\Feedback\Tests\Fixture\DemoFeedbackFixture;
use Domain\Feedback\Tests\Fixture\DemoFeedbackResponseFixture;

/**
 * @backupGlobals disabled
 */
class FeedbackHasAnswerMiddlewareTest extends FeedbackMiddlewareTest
{
    public function testFeedbackHasAnswer200()
    {
        $feedback = DemoFeedbackFixture::getFeedback(2);

        $countResponses = count(DemoFeedbackResponseFixture::getFeedbackResponses());

        $this->requestFeedbackHasAnswer($feedback->getId())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
            ])
            ->expect(function($result) use ($countResponses) {
                $this->assertEquals($countResponses, count($result['entities']));
            });
    }
}