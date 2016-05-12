<?php
namespace Domain\Account\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Account\Entity\Account;
use Domain\Account\Service\AccountService;
use Domain\Auth\Service\AuthService;
use Domain\Auth\Service\CurrentAccountService;
use Zend\Expressive\Application;

class DemoAccountFixture implements Fixture
{
    /** @var Account */
    private static $account;

    const ACCOUNT_EMAIL = 'demo@gmail.com';
    const ACCOUNT_PASSWORD = '1234';

    public function up(Application $app, EntityManager $em) {
        $accountService = $app->getContainer()->get(AccountService::class); /** @var AccountService $accountService */
        $account = $accountService->createAccount(self::ACCOUNT_EMAIL, self::ACCOUNT_PASSWORD);

        $currentAccountService = $app->getContainer()->get(CurrentAccountService::class); /** @var CurrentAccountService $currentAccountService */
        $currentAccountService->forceSignIn($account);

        self::$account = $account;
    }

    public static function getAccount(): Account {
        return self::$account;
    }
}