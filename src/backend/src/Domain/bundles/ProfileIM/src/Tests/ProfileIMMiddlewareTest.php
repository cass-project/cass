<?php

namespace Domain\ProfileIM\Tests;


use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\ProfileIM\Tests\Fixtures\DemoAccountsFixtures;

class ProfileIMMiddlewareTest extends MiddlewareTestCase
{
	protected function getFixtures(): array {

		return [
			new DemoAccountsFixtures(),
		];
	}


	public function sendMessageSuccess()
	{

		$targetProfileId = DemoAccountsFixtures::getAccount(2)->getProfiles()->first();

		$this->requestSendMessage($targetProfileId,["content" => "string"])
			->auth(DemoAccountsFixtures::getAccount(1))
			->execute()
			->expectJSONContentType()
			->expectStatusCode(200)
			->expectJSONBody([
												 'success' => true,
												 'message' => [
													 'id' => $this->expectId(),
													 'date_created' => NULL,
													 'source_profile_id' => null,
													 'target_profile_id' => null,
													 'read_status' => [
														 [
															 "is_read"   => TRUE,
															 "date_read" => "string"
														 ]
													 ],
													 "content"=> "string"
												 ]
											 ])
		;


	}

	protected function requestSendMessage(int $targetProfileId, array $json): RESTRequest {
		return $this->request('PUT', sprintf('/protected/profile-im/send/to/%d',$targetProfileId))
			->setParameters($json);
	}



}