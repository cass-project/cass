<?php
namespace Domain\Feedback\Tests\REST\Paths;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Feedback\FeedbackType\Types\FTCommonQuestion;
use Domain\Feedback\FeedbackType\Types\FTSuggestion;
use Domain\Feedback\FeedbackType\Types\FTThemeRequest;
use Domain\Feedback\Middleware\Parameters\CreateFeedbackParameters;
use Domain\Feedback\Middleware\Parameters\CreateFeedbackResponseParameters;
use Domain\Feedback\Service\FeedbackService;
use Domain\Feedback\Tests\FeedbackMiddlewareTest;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Zend\Expressive\Application;

/**
 * @backupGlobals disabled
 */
class FeedbackListEntitiesMiddlewareTest extends FeedbackMiddlewareTest
{
    public function testGetAllEntities403() {
        $this->upFixture(new FeedbackEntitiesFixture(self::$app->getContainer()->get(FeedbackService::class)));

        $this->requestGetAllFeedbackEntities(0, 100)
            ->execute()
            ->expectAuthError();
    }

    public function testGetAllEntities200() {
        $this->upFixture(new FeedbackEntitiesFixture(self::$app->getContainer()->get(FeedbackService::class)));

        $this->requestGetAllFeedbackEntities(0, 100)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType();
    }
}


class FeedbackEntitiesFixture implements Fixture
{
    /** @var FeedbackService */
    private $service;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->service = $feedbackService;
    }

    public function up(Application $app, EntityManager $em)
    {
        $profile1 = DemoProfileFixture::getProfile();

        $params = [
            [
                'type' => FTCommonQuestion::INT_CODE,
                'read' => false,
                'answer' => false,
            ],
            [
                'type' => FTCommonQuestion::INT_CODE,
                'read' => false,
                'answer' => false,
                'anonymous' => 'demo@gmail.com',
            ],
            [
                'type' => FTCommonQuestion::INT_CODE,
                'read' => false,
                'answer' => false,
            ],
            [
                'type' => FTCommonQuestion::INT_CODE,
                'read' => false,
                'answer' => false,
            ],
            [
                'type' => FTCommonQuestion::INT_CODE,
                'read' => false,
                'answer' => false,
            ],
            [
                'type' => FTThemeRequest::INT_CODE,
                'read' => false,
                'answer' => false,
            ],
            [
                'type' => FTSuggestion::INT_CODE,
                'read' => false,
                'answer' => false,
            ],
            [
                'type' => FTCommonQuestion::INT_CODE,
                'read' => false,
                'answer' => true
            ],
            [
                'type' => FTCommonQuestion::INT_CODE,
                'read' => true,
                'answer' => true,
            ],
            [
                'type' => FTCommonQuestion::INT_CODE,
                'read' => false,
                'answer' => false,
            ],
        ];

        foreach($params as $request) {
            $request = array_merge([
                'type' => FTCommonQuestion::INT_CODE,
                'profile_id' => $profile1->getId(),
                'anonymous' => null,
                'description' => 'Demo Feedback',
                'answer' => false,
                'read' => false
            ], $request);

            if($request['anonymous']) {
                $request['profile_id'] = null;
            }

            $feedback = $this->service->createFeedback(new CreateFeedbackParameters(
                $request['type'],
                $request['description'],
                $request['profile_id'],
                $request['anonymous']
            ));

            if($request['answer']) {
                $this->service->answer(new CreateFeedbackResponseParameters(
                    'Demo Feedback Response',
                    $feedback->getId()
                ));

                if($request['read']) {
                    $this->service->markAsRead($feedback->getId());
                }
            }
        }
    }
}