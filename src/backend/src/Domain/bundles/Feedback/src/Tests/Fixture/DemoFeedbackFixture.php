<?php

namespace Domain\Feedback\Tests\Fixture;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Feedback\Entity\Feedback;
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
        $feedbacks = [
            (new Feedback())->setDescription("string 1")->setType(1),
            (new Feedback())->setDescription("string 2")->setType(2),
            (new Feedback())->setDescription("string 3")->setType(3)
                ->setProfile(DemoAccountFixture::getAccount()->getProfiles()->first()),
            (new Feedback())->setDescription("string 4")->setType(3)
                ->setProfile(DemoAccountFixture::getAccount()->getProfiles()->first()),
            (new Feedback())->setDescription("string 5")->setType(3)
                ->setProfile(DemoAccountFixture::getAccount()->getProfiles()->first()),
            (new Feedback())->setDescription("string 6")->setType(3)
                ->setProfile(DemoAccountFixture::getAccount()->getProfiles()->first()),
        ];

        foreach($feedbacks as $feedback) {
            $em->persist($feedback);
        }
        $em->flush();

        self::$fixtures = $feedbacks;
    }
}