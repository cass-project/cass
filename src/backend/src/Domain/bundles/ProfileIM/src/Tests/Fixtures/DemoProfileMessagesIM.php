<?php


namespace Domain\ProfileIM\Tests\Fixtures;


use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\ProfileIM\Entity\ProfileMessage;
use Domain\ProfileIM\Service\ProfileIMService;
use Zend\Expressive\Application;

class DemoProfileMessagesIM implements Fixture
{
  public function up(Application $app, EntityManager $em){

    /** @var ProfileIMService $profileIMService */
    $profileIMService = $app->getContainer()->get(ProfileIMService::class);

    $currentAccount = DemoAccountsFixtures::getAccount(1);
    $targetAccount = DemoAccountsFixtures::getAccount(2);


    $message = new ProfileMessage($currentAccount->getCurrentProfile(), $targetAccount->getCurrentProfile());
    $message->setContent("test message");
    $profileIMService->createMessage($message);

  }

}