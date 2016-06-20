<?php
namespace Application\Frontline\Tests;

use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\ProfileCommunities\Tests\Fixtures\SamplePCBookmarksFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class IsFrontlineAliveTest extends MiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
            new SampleCommunitiesFixture(),
            new SamplePCBookmarksFixture(),
        ];
    }

    public function testNoExceptionsPlease()
    {
        $this->request('GET', '/frontline/*/')
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType();
    }

    public function testAuthFrontline()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $this->request('GET', '/frontline/*/')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'auth' => [
                    'api_key' => $account->getAPIKey(),
                    'account' => [
                        'id' => $account->getId(),
                        'email' => $account->getEmail(),
                        'disabled' => [
                            'is_disabled' => false
                        ]
                    ],
                    'profiles' => [
                        [
                            'entity' => [
                                'id' => $profile->getId(),
                                'account_id' => $account->getId(),
                                'is_initialized' => $profile->isInitialized(),
                                'is_current' => $profile->isCurrent(),
                                'greetings' => [
                                    'method' => $profile->getGreetings()->getMethod(),
                                    'first_name' => $profile->getGreetings()->getFirstName(),
                                    'last_name' => $profile->getGreetings()->getLastName(),
                                    'middle_name' => $profile->getGreetings()->getMiddleName(),
                                    'nick_name' => $profile->getGreetings()->getNickName(),
                                ],
                                'image' => $this->expectImageCollection(),
                                'expert_in_ids' => function($input) use ($profile) {
                                    $this->assertTrue(is_array($input));
                                    $this->assertEquals($profile->getExpertInIds(), $input);
                                },
                                'interesting_in_ids' => function($input) use ($profile) {
                                    $this->assertTrue(is_array($input));
                                    $this->assertEquals($profile->getInterestingInIds(), $input);
                                },
                            ],
                            'collections' => [
                                [
                                    'id' => $this->expectId(),
                                    'sid' => $this->expectString(),
                                ]
                            ]
                        ]
                    ],
                ],
                'config' => [
                    'account' => [
                        'delete_account_request_days' => function($input) {
                            $this->assertTrue(is_int($input));
                            $this->assertGreaterThan(0, $input);
                        }
                    ],
                    'profile' => [
                        'max_profiles' => function($input) {
                            $this->assertTrue(is_int($input));
                            $this->assertGreaterThan(0, $input);
                        }
                    ],
                    'community' => [
                        'features' => function($input) {
                            $this->assertTrue(is_array($input));

                            foreach($input as $item) {
                                $this->assertTrue(is_array($item));
                                $this->assertTrue(isset($item['code']));
                                $this->assertTrue(is_string($item['code']) && strlen($item['code']) > 0);
                                $this->assertTrue(isset($item['is_development_ready']) && is_bool($item['is_development_ready']));
                                $this->assertTrue(isset($item['is_production_ready']) && is_bool($item['is_production_ready']));
                            }
                        }
                    ]
                ]
            ]);
    }
}