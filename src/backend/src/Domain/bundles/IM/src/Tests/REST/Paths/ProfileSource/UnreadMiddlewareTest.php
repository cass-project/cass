<?php
namespace CASS\Domain\Bundles\IM\Tests\REST\Paths\ProfileSource;

use CASS\Domain\Bundles\IM\Tests\Fixtures\ProfilesFixture;
use CASS\Domain\Bundles\IM\Tests\IMMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class UnreadMiddlewareTest extends IMMiddlewareTest
{
    public function testUnread200()
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
            ],
            4 => [
                'message' => 'Demo IM Message #4',
                'attachment_ids' => []
            ],
            5 => [
                'message' => 'Demo IM Message #5',
                'attachment_ids' => []
            ],
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

        $messageJSON_4 = $this->requestSend($profile_source->getId(), 'profile', $profile_target->getId(), $json[4])
            ->auth($fixture->getAccount(1)->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->fetch(function(array $input) {
                return $input['message'];
            });

        $messageJSON_5 = $this->requestSend($profile_source->getId(), 'profile', $profile_target->getId(), $json[5])
            ->auth($fixture->getAccount(1)->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->fetch(function(array $input) {
                return $input['message'];
            });

        $this->requestUnread($profile_target->getId())
            ->execute()
            ->expectAuthError();

        $this->requestUnread($profile_target->getId())
            ->auth($fixture->getAccount(1)->getAPIKey())
            ->execute()
            ->expectAuthError();

        $this->requestUnread($profile_target->getId())
            ->auth($fixture->getAccount(2)->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'unread' => [
                    0 => [
                        'source' => [
                            'code' => 'profile',
                            'id' => $profile_source->getId(),
                            'entity' =>  $profile_source->toJSON(),
                        ],
                        'counter' => 4
                    ]
                ]
            ])
        ;

        $this->requestUnread($profile_source->getId())
            ->auth($fixture->getAccount(1)->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'unread' => [
                    0 => [
                        'source' => [
                            'code' => 'profile',
                            'id' => $profile_target->getId(),
                            'entity' =>  $profile_target->toJSON(),
                        ],
                        'counter' => 1
                    ]
                ]
            ])
        ;

        $this->requestMessages($profile_target->getId(), 'profile', $profile_source->getId(), [
            'criteria' => [
                'seek' => [
                    'offset' => 0,
                    'limit' => 100
                ]
            ],
            'options' => [
                'markAsRead' => [
                    'message_ids' => [
                        $messageJSON_1['id'],
                        $messageJSON_4['id']
                    ]
                ]
            ]
        ])
            ->auth($fixture->getAccount(2)->getAPIKey())
            ->execute()
            ->expectStatusCode(200);

        $this->requestUnread($profile_target->getId())
            ->auth($fixture->getAccount(2)->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'unread' => [
                    0 => [
                        'source' => [
                            'code' => 'profile',
                            'id' => $profile_source->getId(),
                            'entity' =>  $profile_source->toJSON(),
                        ],
                        'counter' => 2
                    ]
                ]
            ])
        ;
    }
}