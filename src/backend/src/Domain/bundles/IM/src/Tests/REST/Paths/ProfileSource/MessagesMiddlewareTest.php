<?php
namespace CASS\Domain\Bundles\IM\Tests\REST\Paths\ProfileSource;

use CASS\Domain\Bundles\IM\Tests\Fixtures\ProfilesFixture;
use CASS\Domain\Bundles\IM\Tests\IMMiddlewareTest;

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

        $this->requestMessages($profile_target->getId(), 'profile', $profile_source->getId(), [
            'criteria' => [
                'seek' => [
                    'offset' => 0,
                    'limit' => 100
                ]
            ],
            'options' => []
        ])
            ->auth($fixture->getAccount(2)->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'messages' => function(array $json) {
                    $this->assertTrue(is_array($json));
                    $this->assertEquals(5, count($json));
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
                    $messageJSON_4,
                    $messageJSON_5,
                ]
            ])
        ;

        $this->requestMessages($profile_source->getId(), 'profile', $profile_target->getId(), [
            'criteria' => [
                'seek' => [
                    'offset' => 0,
                    'limit' => 100
                ]
            ],
            'options' => []
        ])
            ->auth($fixture->getAccount(1)->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'messages' => function(array $json) {
                    $this->assertTrue(is_array($json));
                    $this->assertEquals(5, count($json));
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
                    $messageJSON_4,
                    $messageJSON_5,
                ]
            ])
        ;

        $this->requestMessages($profile_source->getId(), 'profile', $profile_target->getId(), [
            'criteria' => [
                'seek' => [
                    'offset' => 0,
                    'limit' => 100
                ],
                'sort' => [
                    'field' => '_id',
                    'order' => 'desc'
                ]
            ],
            'options' => []
        ])
            ->auth($fixture->getAccount(1)->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'messages' => function(array $json) {
                    $this->assertTrue(is_array($json));
                    $this->assertEquals(5, count($json));
                }
            ])
            ->expectJSONBody([
                'success' => true,
                'source' => [
                    'code' => 'profile',
                    'entity' => $profile_target->toJSON()
                ],
                'messages' => [
                    $messageJSON_5,
                    $messageJSON_4,
                    $messageJSON_3,
                    $messageJSON_2,
                    $messageJSON_1,
                ]
            ])
        ;

        $this->requestMessages($profile_source->getId(), 'profile', $profile_target->getId(), [
            'criteria' => [
                'seek' => [
                    'offset' => 1,
                    'limit' => 100
                ],
                'sort' => [
                    'field' => '_id',
                    'order' => 'desc'
                ]
            ],
            'options' => []
        ])
            ->auth($fixture->getAccount(1)->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'messages' => function(array $json) {
                    $this->assertTrue(is_array($json));
                    $this->assertEquals(4, count($json));
                }
            ])
            ->expectJSONBody([
                'success' => true,
                'source' => [
                    'code' => 'profile',
                    'entity' => $profile_target->toJSON()
                ],
                'messages' => [
                    $messageJSON_4,
                    $messageJSON_3,
                    $messageJSON_2,
                    $messageJSON_1,
                ]
            ])
        ;

        $this->requestMessages($profile_source->getId(), 'profile', $profile_target->getId(), [
            'criteria' => [
                'seek' => [
                    'offset' => 1,
                    'limit' => 2
                ],
                'sort' => [
                    'field' => '_id',
                    'order' => 'desc'
                ]
            ],
            'options' => []
        ])
            ->auth($fixture->getAccount(1)->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'messages' => function(array $json) {
                    $this->assertTrue(is_array($json));
                    $this->assertEquals(2, count($json));
                }
            ])
            ->expectJSONBody([
                'success' => true,
                'source' => [
                    'code' => 'profile',
                    'entity' => $profile_target->toJSON()
                ],
                'messages' => [
                    $messageJSON_4,
                    $messageJSON_3,
                ]
            ])
        ;

        $this->requestMessages($profile_source->getId(), 'profile', $profile_target->getId(), [
            'criteria' => [
                'seek' => [
                    'offset' => 0,
                    'limit' => 100
                ],
                'cursor' => [
                    'id' => $messageJSON_4['id'],
                ],
                'sort' => [
                    'field' => '_id',
                    'order' => 'desc'
                ]
            ],
            'options' => []
        ])
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
                    $messageJSON_3,
                    $messageJSON_2,
                    $messageJSON_1,
                ]
            ])
        ;

        $this->requestMessages($profile_source->getId(), 'profile', $profile_target->getId(), [
            'criteria' => [
                'seek' => [
                    'offset' => 0,
                    'limit' => 100
                ],
                'cursor' => [
                    'id' => $messageJSON_4['id'],
                ],
                'sort' => [
                    'field' => '_id',
                    'order' => 'asc'
                ]
            ],
            'options' => []
        ])
            ->auth($fixture->getAccount(1)->getAPIKey())
            ->execute()
            ->dump()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'messages' => function(array $json) {
                    $this->assertTrue(is_array($json));
                    $this->assertEquals(1, count($json));
                }
            ])
            ->expectJSONBody([
                'success' => true,
                'source' => [
                    'code' => 'profile',
                    'entity' => $profile_target->toJSON()
                ],
                'messages' => [
                    $messageJSON_5,
                ]
            ])
        ;
    }
}