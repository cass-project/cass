<?php
namespace Domain\Account\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Account\Entity\Account;
use Domain\Auth\Service\CurrentAccountService;
use Zend\Expressive\Application;

class DemoAccountFixture implements Fixture
{
    /** @var Account */
    private static $account;

    const ACCOUNT_EMAIL = 'demo@gmail.com';
    const ACCOUNT_PASSWORD = '1234';

    public function up(Application $app, EntityManager $em) {
        $account = new Account();
        $account
            ->setEmail(self::ACCOUNT_EMAIL)
            ->setPassword(self::ACCOUNT_PASSWORD)
        ;

        $em->persist($account);
        $em->flush($account);

        $currentAccountService = $app->getContainer()->get(CurrentAccountService::class); /** @var CurrentAccountService $currentAccountService */
        $currentAccountService->forceSignIn($account);

        self::$account = $account;
    }

    public static function getAccount(): Account {
        return self::$account;
    }
}