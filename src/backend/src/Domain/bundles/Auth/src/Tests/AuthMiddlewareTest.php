<?php
namespace CASS\Domain\Bundles\Auth\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use ZEA2\Platform\Bundles\PHPUnit\RESTRequest\RESTRequest;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class AuthMiddlewareTest extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [];
    }

    public function testSignUp()
    {
        $json = [
            'email' => 'demo@gmail.com',
            'password' => '1234'
        ];

        $this->requestSignUp($json)
            ->execute()
            ->dump()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'api_key' => $this->expectString(),
                'account' => [
                    'id' => $this->expectId(),
                    'email' => $json['email'],
                    'disabled' => [
                        'is_disabled' => false
                    ]
                ],
                'profiles' => [
                    0 => [
                        'is_own' => true,
                        'profile' => [
                            'id' => $this->expectId(),
                            'account_id' => $this->expectId(),
                            'is_initialized' => false,
                            'is_current' => true,
                        ],
                        'collections' => [
                            0 => [
                                'id' => $this->expectId(),
                                'sid' => $this->expectString(),
                                'title' => $this->expectString(),
                                'description' => $this->expectString()
                            ]
                        ]
                    ]
                ]
            ])
        ;
    }

    public function testSignUpDuplicateAttempt()
    {
        $json = [
            'email' => 'demo@gmail.com',
            'password' => '1234',
        ];

        $request = $this->requestSignUp($json);

        $request->execute();
        $request->execute()
            ->expectStatusCode(409)
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString()
        ]);
    }

    public function testSignIn()
    {
        $this->upFixtures([
            new DemoAccountFixture(),
            new DemoProfileFixture()
        ]);

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $json = [
            'email' => $account->getEmail(),
            'password' => DemoAccountFixture::ACCOUNT_PASSWORD
        ];

        $this->requestSignIn($json)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'api_key' => $account->getAPIKey(),
                'account' => [
                    'id' => $account->getId(),
                    'email' => $account->getEmail(),
                    'disabled' => [
                        'is_disabled' => false
                    ]
                ],
                'profiles' => [
                    0 => [
                        'profile' => [
                            'id' => $profile->getId(),
                            'account_id' => $account->getId(),
                            'is_initialized' => false,
                            'is_current' => true,
                        ],
                        'collections' => [
                            0 => [
                                'id' => $this->expectId(),
                                'sid' => $this->expectString(),
                                'title' => $this->expectString(),
                                'description' => $this->expectString(),
                            ]
                        ]
                    ]
                ]
            ])
        ;
    }

    private function requestSignUp(array $json): RESTRequest
    {
        return $this->request('PUT', '/auth/sign-up')
            ->setParameters($json);
    }

    private function requestSignIn(array $json): RESTRequest
    {
        return $this->request('POST', '/auth/sign-in')
            ->setParameters($json);
    }
}