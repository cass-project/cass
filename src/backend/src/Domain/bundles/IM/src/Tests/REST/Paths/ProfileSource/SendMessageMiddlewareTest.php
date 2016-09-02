<?php
namespace CASS\Domain\Bundles\IM\Tests\REST\Paths\ProfileSource;

use CASS\Domain\Bundles\IM\Tests\Fixtures\ProfilesFixture;
use CASS\Domain\Bundles\IM\Tests\IMMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class SendMessageMiddlewareTest extends IMMiddlewareTest
{
    public function testSendMessageProfileToProfile403Protected()
    {
        $fixture = new ProfilesFixture();

        $this->upFixture($fixture);

        $profile_source = $fixture->getAccount(1)->getCurrentProfile();
        $profile_target = $fixture->getAccount(2)->getCurrentProfile();

        $json = [
            'message' => 'Demo IM Message',
            'attachment_ids' => []
        ];

        $this->requestSend($profile_source->getId(), 'profile', $profile_target->getId(), $json)
            ->execute()
            ->expectAuthError();
    }

    public function testSendMessageProfileToProfile403ProfileNotFound()
    {
        $fixture = new ProfilesFixture();

        $this->upFixture($fixture);

        $profile_source = $fixture->getAccount(1)->getCurrentProfile();
        $profile_target = $fixture->getAccount(2)->getCurrentProfile();

        $json = [
            'message' => 'Demo IM Message',
            'attachment_ids' => []
        ];

        $this->requestSend($profile_source->getId(), 'profile', $profile_target->getId(), $json)
            ->auth($fixture->getAccount(3)->getAPIKey())
            ->execute()
            ->expectAuthError();
    }

    public function testSendMessageProfileToProfile200()
    {
        $fixture = new ProfilesFixture();

        $this->upFixture($fixture);

        $profile_source = $fixture->getAccount(1)->getCurrentProfile();
        $profile_target = $fixture->getAccount(2)->getCurrentProfile();

        $json = [
            'message' => 'Demo IM Message',
            'attachment_ids' => []
        ];

        $this->requestSend($profile_source->getId(), 'profile', $profile_target->getId(), $json)
            ->auth($fixture->getAccount(1)->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'message' => [
                    'id' => $this->expectString(),
                    'author' => $profile_source->toJSON(),
                    'date_created' => $this->expectString(),
                    'content' => $json['message'],
                ]
            ]);
        ;
    }
}