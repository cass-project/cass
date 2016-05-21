<?php

namespace Domain\ProfileIM\Tests;


use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\ProfileIM\Tests\Fixtures\DemoAccountsFixtures;

/**
 * @backupGlobals disabled
 */
class ProfileIMMiddlewareTest extends MiddlewareTestCase
{
	protected function getFixtures(): array {

		return [
			new DemoAccountsFixtures(),
		];
	}

	public function testSendMessage()
	{
		$targetProfileId = DemoAccountsFixtures::getAccount(2)->getProfiles()->first()->getId();
		$currentAccount = DemoAccountsFixtures::getAccount(1);

		$this->requestSendMessage($targetProfileId, ["content" => "string"])
			->auth($currentAccount->getAPIKey())
			->execute()
			->dump()
			->expectJSONContentType()
			->expectStatusCode(200)
			->expectJSONBody([
												 'success' => true
											 ])

		;
	}

	public function testSendMessage403()
	{

		$targetProfileId = DemoAccountsFixtures::getAccount(2)->getProfiles()->first()->getId();

		$this->requestSendMessage($targetProfileId, ["content" => "string"])
			->execute()
			->expectAuthError();
	}

	protected function requestSendMessage(int $targetProfileId, array $json): RESTRequest
	{
		return $this->request('PUT', sprintf('/protected/profile-im/send/to/%d',$targetProfileId))
			->setParameters($json);
	}

	protected function requestProfileIMGet($sourceProfileId, $offset, $limit): RESTRequest
	{
		return $this->request('GET', sprintf('/protected/profile-im/messages/from/%d/offset/%d/limit/%d',
																				 $sourceProfileId,
																				 $offset,
																				 $limit));
	}

	protected function requestProfileIMUnreadGet(): RESTRequest
	{
		return $this->request('GET', '/protected/profile-im/unread');
	}
}