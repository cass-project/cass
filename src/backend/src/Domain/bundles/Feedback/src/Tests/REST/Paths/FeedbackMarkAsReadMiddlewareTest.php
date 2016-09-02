<?php
namespace CASS\Domain\Bundles\Feedback\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Feedback\FeedbackType\Types\FTCommonQuestion;
use CASS\Domain\Bundles\Feedback\Tests\FeedbackMiddlewareTest;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class FeedbackMarkAsReadMiddlewareTest extends FeedbackMiddlewareTest
{
    public function testMarkAsRead403()
    {
        $feedbackIdA = $this->createFeedbackWithResponse();

        $this->requestMarkAsRead($feedbackIdA)
            ->execute()
            ->expectAuthError();
    }

    public function testMarkAsRead404()
    {
        $this->requestMarkAsRead(999999)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testMarkAsRead409()
    {
        $feedbackId = $this->createFeedbackWithoutResponse();

        $this->requestMarkAsRead($feedbackId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString()
            ]);
    }

    public function testMarkAsRead200()
    {
        $feedbackId = $this->createFeedbackWithResponse();

        $this->requestMarkAsRead($feedbackId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }

    private function createFeedbackWithoutResponse(): int
    {
        $profile = DemoProfileFixture::getProfile();

        $this->requestFeedbackCreate([
            "profile_id" => $profile->getId(),
            "type_feedback" => FTCommonQuestion::INT_CODE,
            "description" => "Demo Feedback"
        ])
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'created_at' => $this->expectString(),
                    'profile' => [
                        'has' => true,
                        'entity' => $profile->toJSON()
                    ],
                ]
            ])
        ;

        return (int) self::$currentResult->getContent()['entity']['id'];
    }
    
    private function createFeedbackWithResponse(): int
    {
        $profile = DemoProfileFixture::getProfile();

        $this->requestFeedbackCreate([
            "profile_id" => $profile->getId(),
            "type_feedback" => FTCommonQuestion::INT_CODE,
            "description" => "Demo Feedback"
        ])
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'created_at' => $this->expectString(),
                    'profile' => [
                        'has' => true,
                        'entity' => $profile->toJSON()
                    ],
                ]
            ]);

        $feedbackId = (int) self::$currentResult->getContent()['entity']['id'];
        
        $this->requestCreateFeedbackResponse([
            'feedback_id' => $feedbackId,
            'description' => 'Demo Feedback Response'
        ])
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'description' => $this->expectString(),
                ]
            ]);
        
        return $feedbackId;
    }
}