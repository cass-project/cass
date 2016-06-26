<?php

namespace Domain\Feedback\Tests\Fixture;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Feedback\Entity\FeedbackResponse;
use Zend\Expressive\Application;

class DemoFeedbackResponseFixture implements Fixture
{
    static protected $feedbackResponses;

    static public function getFeedbackResponses():array
    {
        return self::$feedbackResponses;
    }

    static public function getFeedbackResponse(int $index):FeedbackResponse
    {
        return self::$feedbackResponses[$index];
    }

    public function up(Application $app, EntityManager $em)
    {

        $feedback = DemoFeedbackFixture::getFeedback(2);
        $feedbackResponses = [
            (new FeedbackResponse())
                ->setDescription("text 1")
                ->setCreatedAt(new \DateTime())
                ->setFeedback($feedback),
            (new FeedbackResponse())
                ->setDescription("text 2")
                ->setCreatedAt(new \DateTime())
                ->setFeedback($feedback),
            (new FeedbackResponse())
                ->setDescription("text 3")
                ->setCreatedAt(new \DateTime())
                ->setFeedback($feedback),
        ];

        foreach($feedbackResponses as $response) {
            $em->persist($response);
        }
        $em->flush();
        self::$feedbackResponses = $feedbackResponses;
    }
}