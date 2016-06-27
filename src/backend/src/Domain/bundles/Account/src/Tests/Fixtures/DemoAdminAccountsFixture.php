<?php
namespace Domain\Account\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Account\Entity\Account;
use Domain\Account\Entity\AccountAppAccess;
use Domain\Account\Service\AccountAppAccessService;
use Domain\Account\Service\AccountService;
use Zend\Expressive\Application;

final class DemoAdminAccountsFixture implements Fixture
{
    /** @var Account[] */
    private static $accounts = [];

    const ACCOUNT_PASSWORD = '1234';

    public function up(Application $app, EntityManager $em)
    {
        $accountService = $app->getContainer()->get(AccountService::class); /** @var AccountService $accountService */
        $appAccessAccountService = $app->getContainer()->get(AccountAppAccessService::class); /** @var AccountAppAccessService $account */

        $all = $accountService->createAccount('admin-all@gmail.com', self::ACCOUNT_PASSWORD);
        $admin = $accountService->createAccount('admin-only@gmail.com', self::ACCOUNT_PASSWORD);
        $reports = $accountService->createAccount('admin-reports@gmail.com', self::ACCOUNT_PASSWORD);
        $feedback = $accountService->createAccount('admin-feedback@gmail.com', self::ACCOUNT_PASSWORD);

        $ac_all = new AccountAppAccess($all);
        $ac_all->allowAdmin();
        $ac_all->allowFeedback();
        $ac_all->allowReports();

        $ac_admin = new AccountAppAccess($admin);
        $ac_admin->allowAdmin();

        $ac_reports = new AccountAppAccess($reports);
        $ac_reports->allowReports();

        $ac_feedback = new AccountAppAccess($feedback);
        $ac_feedback->allowFeedback();

        $appAccessAccountService->applyAppAccess($ac_all);
        $appAccessAccountService->applyAppAccess($ac_admin);
        $appAccessAccountService->applyAppAccess($ac_reports);
        $appAccessAccountService->applyAppAccess($ac_feedback);

        self::$accounts = [
            'all' => $all,
            'admin' => $admin,
            'reports' => $reports,
            'feedback' => $feedback,
        ];
    }

    public static function getAllAccount(): Account
    {
        return self::$accounts['all'];
    }

    public static function getAdminAccount(): Account
    {
        return self::$accounts['admin'];
    }

    public static function getReportsAccount(): Account
    {
        return self::$accounts['reports'];
    }

    public static function getFeedbackAccount(): Account
    {
        return self::$accounts['feedback'];
    }
}