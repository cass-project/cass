<?php
namespace Domain\ProfileIM\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\ProfileIM\Tests\Fixtures\DemoAccountsFixtures;
use Domain\ProfileIM\Tests\Fixtures\DemoProfileMessagesIM;

/**
 * @backupGlobals disabled
 */
class ProfileIMMiddlewareTest extends MiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountsFixtures(),
            new DemoProfileMessagesIM()
        ];
    }

    public function testSendMessage200()
    {
        $targetProfileId = DemoAccountsFixtures::getAccount(2)->getProfiles()->first()->getId();
        $currentAccount = DemoAccountsFixtures::getAccount(1);

        $this->requestSendMessage($targetProfileId, ["content" => "string"])
            ->auth($currentAccount->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                    'success' => TRUE
                ]
            );
    }

    public function testSendMessage403()
    {
        $targetProfileId = DemoAccountsFixtures::getAccount(2)->getProfiles()->first()->getId();

        $this->requestSendMessage($targetProfileId, ["content" => "string"])
            ->execute()
            ->expectAuthError();
    }

    public function testSendMessage404()
    {
        $currentAccount = DemoAccountsFixtures::getAccount(1);

        $this->requestSendMessage(9999, ["content" => "string"])
            ->auth($currentAccount->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(404)
            ->expectJSONBody([
                    'success' => FALSE
                ]
            );
    }

    public function testGetMessage200()
    {
        $targetProfile = DemoAccountsFixtures::getAccount(2)->getProfiles()->first();
        $targetProfileId = $targetProfile->getId();
        $currentAccount = DemoAccountsFixtures::getAccount(1);

        $this->requestProfileIMGet($targetProfileId, 0, 1)
            ->auth($currentAccount->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                    'success' => TRUE
                ]
            );
    }

    public function testGetMessage403()
    {
        $targetProfile = DemoAccountsFixtures::getAccount(2)->getProfiles()->first();
        $targetProfileId = $targetProfile->getId();

        $this->requestProfileIMGet($targetProfileId, 0, 1)
            ->execute()
            ->expectAuthError();
    }

    public function testGetMessage404()
    {
        $currentAccount = DemoAccountsFixtures::getAccount(1);

        $this->requestProfileIMGet(99999, 0, 1)
            ->auth($currentAccount->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(404)
            ->expectJSONBody([
                    'success' => FALSE
                ]
            );
    }

    public function testGetMessagesUnread200()
    {
        $currentAccount = DemoAccountsFixtures::getAccount(1);

        $this->requestProfileIMUnreadGet()
            ->auth($currentAccount->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                    'success' => TRUE
                ]
            );
    }

    public function testGetMessagesUnread403()
    {
        $this->requestProfileIMUnreadGet()
            ->execute()
            ->expectAuthError();
    }

    protected function requestSendMessage(int $targetProfileId, array $json): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/profile-im/send/to/%d', $targetProfileId))
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