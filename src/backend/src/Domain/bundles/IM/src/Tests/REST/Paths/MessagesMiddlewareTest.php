<?php
namespace Domain\IM\Tests\REST\Paths;

use Domain\IM\Tests\Fixtures\ProfilesFixture;
use Domain\IM\Tests\IMMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class MessagesMiddlewareTest extends IMMiddlewareTest
{
    public function testProfileMessages200()
    {
        $fixture = new ProfilesFixture();

        $this->upFixture($fixture);

        $profile_source = $fixture->getAccount(1)->getCurrentProfile();
        $profile_target = $fixture->getAccount(2)->getCurrentProfile();

        $json = [
            1 => [
                'message' => 'Demo IM Message #1',
                'attachment_ids' => []
            ],
            2 => [
                'message' => 'Demo IM Message #2',
                'attachment_ids' => []
            ],
            3 => [
                'message' => 'Demo IM Message #3',
                'attachment_ids' => []
            ]
        ];

        $messageJSON_1 = $this->requestSend($profile_source->getId(), 'profile', $profile_target->getId(), $json[1])
            ->auth($fixture->getAccount(1)->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->fetch(function(array $input) {
                return $input['message'];
            });

        $messageJSON_2 = $this->requestSend($profile_target->getId(), 'profile', $profile_source->getId(), $json[2])
            ->auth($fixture->getAccount(2)->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->fetch(function(array $input) {
                return $input['message'];
            });

        $messageJSON_3 = $this->requestSend($profile_source->getId(), 'profile', $profile_target->getId(), $json[3])
            ->auth($fixture->getAccount(1)->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->fetch(function(array $input) {
                return $input['message'];
            });

        $jsonRequest = [
            'criteria' => [
                'seek' => [
                    'offset' => 0,
                    'limit' => 100
                ]
            ],
            'options' => []
        ];

        $this->requestMessages($profile_target->getId(), 'profile', $profile_source->getId(), $jsonRequest)
            ->auth($fixture->getAccount(2)->getAPIKey())
            ->execute()
            ->dump()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'messages' => function(array $json) {
                    $this->assertTrue(is_array($json));
                    $this->assertEquals(3, count($json));
                }
            ])
            ->expectJSONBody([
                'success' => true,
                'source' => [
                    'code' => 'profile',
                    'entity' => $profile_source->toJSON()
                ],
                'messages' => [
                    $messageJSON_1,
                    $messageJSON_2,
                    $messageJSON_3,
                ]
            ])
        ;

        $this->requestMessages($profile_source->getId(), 'profile', $profile_target->getId(), $jsonRequest)
            ->auth($fixture->getAccount(1)->getAPIKey())
            ->execute()
            ->dump()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'messages' => function(array $json) {
                    $this->assertTrue(is_array($json));
                    $this->assertEquals(3, count($json));
                }
            ])
            ->expectJSONBody([
                'success' => true,
                'source' => [
                    'code' => 'profile',
                    'entity' => $profile_target->toJSON()
                ],
                'messages' => [
                    $messageJSON_1,
                    $messageJSON_2,
                    $messageJSON_3,
                ]
            ])
        ;
    }
}