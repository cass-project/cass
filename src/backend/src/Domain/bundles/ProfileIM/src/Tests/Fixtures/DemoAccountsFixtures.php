<?php
namespace Domain\ProfileIM\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Account\Entity\Account;
use Domain\Account\Service\AccountService;
use Zend\Expressive\Application;

class DemoAccountsFixtures implements Fixture
{

	private static $accounts;


	public function up(Application $app, EntityManager $em){

		/** @var AccountService $accountService */
		$accountService = $app->getContainer()->get(AccountService::class);

		self::$accounts = [
			1 => $accountService->createAccount('test1@mail.ru', 'test'),
			2 => $accountService->createAccount('test2@mail.ru', 'test')
		];

	}


	static public function getAccounts():array
	{
		return self::$accounts;
	}

	static public function getAccount(int $index): Account
	{
		return self::$accounts[$index];
	}

}