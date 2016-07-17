<?php
namespace Domain\IM\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Application\Util\GenerateRandomString;
use Doctrine\ORM\EntityManager;
use Domain\Account\Entity\Account;
use Domain\Account\Service\AccountService;
use Zend\Expressive\Application;

final class ProfilesFixture implements Fixture
{
    /** @var Account[] */
    private $accounts = [];

    public function up(Application $app, EntityManager $em)
    {
        /** @var AccountService $accountService */
        $accountService = $app->getContainer()->get(AccountService::class);

        for($i = 1; $i <= 5; $i++) {
            $this->accounts[$i] = $accountService->createAccount(sprintf('demo_im_%s@gmail.com', GenerateRandomString::gen(8)), '1234');
        }
    }

    public function getAccount(int $index)
    {
        return $this->accounts[$index];
    }
}