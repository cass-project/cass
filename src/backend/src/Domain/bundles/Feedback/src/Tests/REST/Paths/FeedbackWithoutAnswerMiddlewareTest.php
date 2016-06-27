<?php
namespace Domain\Feedback\Tests\REST\Paths;

use Domain\Feedback\Tests\FeedbackMiddlewareTest;

/**
 * @backupGlobals disabled
 */
class FeedbackWithoutAnswerMiddlewareTest extends FeedbackMiddlewareTest
{
    public function testGetWithoutAnswer200() {}
}