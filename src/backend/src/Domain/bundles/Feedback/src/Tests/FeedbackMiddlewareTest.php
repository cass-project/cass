<?php
namespace Domain\Feedback\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Feedback\Tests\Fixture\DemoFeedbackFixture;
use Domain\Feedback\Tests\Fixture\DemoFeedbackResponseFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
abstract class FeedbackMiddlewareTest extends MiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new DemoFeedbackFixture(),
            new DemoFeedbackResponseFixture()
        ];
    }

    protected function requestFeedbackCreate(array $json): RESTRequest
    {
        return $this->request('PUT', '/feedback/create')->setParameters($json);
    }

    protected function requestFeedbackDelete(int $feedbackId): RESTRequest
    {
        return $this->request('DELETE', sprintf("/feedback/%s/cancel", $feedbackId));
    }

    protected function requestFeedbackHasAnswer(int $feedbackId): RESTRequest
    {
        return $this->request('GET', sprintf("/feedback/%s/has-answer", $feedbackId));
    }

    protected function requestFeedbackEntitiesWithoutAnswer(): RESTRequest
    {
        return $this->request('GET', "/feedback/without-answer");
    }

    protected function requestGetAllFeedbackEntities(int $limit, int $offset): RESTRequest
    {
        return $this->request('GET', sprintf("/protected/feedback/all/limit/%d/offset/%d", $limit, $offset));
    }
}