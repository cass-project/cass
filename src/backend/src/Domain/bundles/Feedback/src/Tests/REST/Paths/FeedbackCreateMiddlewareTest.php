<?php
namespace CASS\Domain\Bundles\Feedback\Tests\REST\Paths;


use CASS\Domain\Bundles\Feedback\FeedbackType\Types\FTCommonQuestion;
use CASS\Domain\Bundles\Feedback\Tests\FeedbackMiddlewareTest;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class FeedbackCreateMiddlewareTest extends FeedbackMiddlewareTest
{
    public function testCreateEmptyDescription400()
    {
        $profile = DemoProfileFixture::getProfile();

        $json = [
            "profile_id" => $profile->getId(),
            "type_feedback" => FTCommonQuestion::INT_CODE,
            "description" => ""
        ];

        $this->requestFeedbackCreate($json)
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(400)
            ->expectJSONBody([
                'success' => false
            ]);
    }

    public function testCreateUnknownType400()
    {
        $profile = DemoProfileFixture::getProfile();

        $json = [
            "profile_id" => $profile->getId(),
            "type_feedback" => 9999999,
            "description" => "Demo Feedback"
        ];

        return $this->requestFeedbackCreate($json)
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(400)
            ->expectJSONBody([
                'success' => false
            ]);
    }

    public function testCreateUnknownProfile404()
    {
        $json = [
            "profile_id" => 9999999,
            "type_feedback" => FTCommonQuestion::INT_CODE,
            "description" => "string"
        ];

        return $this->requestFeedbackCreate($json)->execute()
            ->expectJSONContentType()
            ->expectNotFoundError();
    }

    public function testFeedbackCreate200()
    {
        $profile = DemoProfileFixture::getProfile();

        $json = [
            "profile_id" => $profile->getId(),
            "type_feedback" => FTCommonQuestion::INT_CODE,
            "description" => "Demo Feedback"
        ];

        $this->requestFeedbackCreate($json)->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'type' => $json['type_feedback'],
                    'created_at' => $this->expectString(),
                    'profile' => [
                        'has' => true,
                        'entity' => $profile->toJSON()
                    ],
                    'description' => $json['description'],
                ]
            ]);
    }

    public function testFeedbackCreateAnonymous200()
    {
        $profile = DemoProfileFixture::getProfile();

        $json = [
            "profile_id" => $profile->getId(),
            "type_feedback" => FTCommonQuestion::INT_CODE,
            "description" => "Demo Feedback"
        ];

        $this->requestFeedbackCreate($json)->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'type' => $json['type_feedback'],
                    'created_at' => $this->expectString(),
                    'profile' => [
                        'has' => true,
                        'entity' => $profile->toJSON()
                    ],
                    'description' => $json['description'],
                ]
            ]);
    }
}