<?php
namespace CASS\Domain\Feedback\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use ZEA2\Platform\Bundles\PHPUnit\RESTRequest\RESTRequest;
use CASS\Domain\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Feedback\Tests\Fixture\DemoFeedbackFixture;
use CASS\Domain\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
abstract class FeedbackMiddlewareTest extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new DemoFeedbackFixture(),
        ];
    }

    protected function requestFeedbackCreate(array $json): RESTRequest
    {
        return $this->request('PUT', '/feedback/create')->setParameters($json);
    }

    protected function requestFeedbackDelete(int $feedbackId): RESTRequest
    {
        return $this->request('DELETE', sprintf("/protected/feedback/%s/cancel", $feedbackId));
    }

    protected function requestFeedbackHasAnswer(int $feedbackId): RESTRequest
    {
        return $this->request('GET', sprintf("/feedback/%s/has-answer", $feedbackId));
    }

    protected function requestFeedbackEntitiesWithoutAnswer(): RESTRequest
    {
        return $this->request('GET', "/feedback/without-answer");
    }

    protected function requestGetAllFeedbackEntities(int $limit, int $offset, array $queryParams = null): RESTRequest
    {
        return $this->request('GET', sprintf("/protected/feedback/list/offset/%d/limit/%d", $offset, $limit), $queryParams);
    }

    protected function requestMarkAsRead(int $feedbackId): RESTRequest
    {
        return $this->request('POST', sprintf('/protected/feedback/%d/mark-as-read', $feedbackId));
    }

    protected function requestGetById(int $feedbackId): RESTRequest
    {
        return $this->request('GET', sprintf('/protected/feedback/%d/get', $feedbackId));
    }

    protected function requestCreateFeedbackResponse(array $json): RESTRequest
    {
        return $this->request('PUT', '/protected/feedback-response/create')
            ->setParameters($json);
    }
}