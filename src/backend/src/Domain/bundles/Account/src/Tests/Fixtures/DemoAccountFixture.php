<?php
namespace Domain\Account\Tests\Fixtures;

use CASS\Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Account\Entity\Account;
use Domain\Account\Service\AccountService;
use Domain\Auth\Service\CurrentAccountService;
use Zend\Expressive\Application;

class DemoAccountFixture implements Fixture
{
    /** @var Account */
    private static $account;

    /** @var Account */
    private static $secondAccount;

    const ACCOUNT_EMAIL = 'demo@mail.com';
    const ACCOUNT_EMAIL_SECOND = 'demo2@mail.com';
    const ACCOUNT_PASSWORD = '1234';

    public function up(Application $app, EntityManager $em)
    {
        $accountService = $app->getContainer()->get(AccountService::class); /** @var AccountService $accountService */
        $currentAccountService = $app->getContainer()->get(CurrentAccountService::class); /** @var CurrentAccountService $currentAccountService */

        $account = $accountService->createAccount(self::ACCOUNT_EMAIL, self::ACCOUNT_PASSWORD);
        $accountSecond = $accountService->createAccount(self::ACCOUNT_EMAIL_SECOND, self::ACCOUNT_PASSWORD);
        $currentAccountService->signInWithAccount($account);

        self::$account = $account;
        self::$secondAccount = $accountSecond;
    }

    public static function getAccount(): Account
    {
        return self::$account;
    }

    public static function getSecondAccount(): Account
    {
        return self::$secondAccount;
    }
}