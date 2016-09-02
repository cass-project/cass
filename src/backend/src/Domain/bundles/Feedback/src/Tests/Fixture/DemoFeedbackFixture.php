<?php

namespace CASS\Domain\Bundles\Feedback\Tests\Fixture;

use ZEA2\Platform\Bundles\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Feedback\Entity\Feedback;
use CASS\Domain\Bundles\Feedback\FeedbackType\Types\FTCommonQuestion;
use Zend\Expressive\Application;

class DemoFeedbackFixture implements Fixture
{
    static protected $fixtures;

    static public function getFeedbacks():array
    {
        return self::$fixtures;
    }

    static public function getFeedback(int $index): Feedback
    {
        return self::$fixtures[$index];
    }

    public function up(Application $app, EntityManager $em)
    {
        $profile = DemoAccountFixture::getAccount()->getProfiles()->first();

        $feedbackEntities = [];
        $feedbackEntities[] = (new Feedback(new FTCommonQuestion(), 'Demo Feedback 1'));
        $feedbackEntities[] = (new Feedback(new FTCommonQuestion(), 'Demo Feedback 2'));
        $feedbackEntities[] = (new Feedback(new FTCommonQuestion(), 'Demo Feedback 3', $profile));
        $feedbackEntities[] = (new Feedback(new FTCommonQuestion(), 'Demo Feedback 4', $profile));
        $feedbackEntities[] = (new Feedback(new FTCommonQuestion(), 'Demo Feedback 5', $profile));

        foreach($feedbackEntities as $feedback) {
            $em->persist($feedback);
            $em->flush($feedback);
        }

        self::$fixtures = $feedbackEntities;
    }
}