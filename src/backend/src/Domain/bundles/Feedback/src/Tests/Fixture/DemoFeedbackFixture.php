<?php


namespace Domain\Feedback\Tests\Fixture;


use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
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

  public function up(Application $app, EntityManager $em){
    $feedbacks = [
      (new Feedback())->setCreatedAt(new \DateTime())->setDescription("string 1")->setType(1),
      (new Feedback())->setCreatedAt(new \DateTime())->setDescription("string 2")->setType(2),
      (new Feedback())->setCreatedAt(new \DateTime())->setDescription("string 3")->setType(3),

    ];

    foreach($feedbacks as $feedback ){
      $em->persist($feedback);
    }
    $em->flush();

    self::$fixtures = $feedbacks;
  }
}