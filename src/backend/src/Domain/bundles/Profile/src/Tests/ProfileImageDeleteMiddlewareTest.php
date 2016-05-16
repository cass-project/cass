<?php
namespace Domain\Profile\Tests;

use Application\Util\Definitions\Point;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Entity\ProfileImage;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class ProfileImageDeleteMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testUploadImage()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $p1 = new Point(0, 0);
        $p2 = new Point(150, 150);
        $localFile = __DIR__.'/Resources/grid-example.png';

        $wwwPath = $this->container()->get('paths')['www'];

        $this->requestUploadImage($profile->getId(), $p1, $p2, $localFile)
            ->execute()
            ->expectAuthError();

        $this->requestUploadImage($profile->getId(), $p1, $p2, $localFile)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'profile_id' => $profile->getId(),
                'public_path' => $this->expectString()
            ])
            ->expect(function(array $result) use ($wwwPath) {
                $file = sprintf('%s/%s', $wwwPath, $result['public_path']);

                $this->assertTrue(file_exists($file));
            })
        ;

        $this->requestDeleteImage($profile->getId())
            ->execute()
            ->expectAuthError();

        $this->requestDeleteImage($profile->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ]);

        $this->requestGetProfile($profile->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'image' => [
                        'id' => $this->expectId(),
                        'profile_id' => $profile->getId(),
                        'public_path' => ProfileImage::DEFAULT_PROFILE_IMAGE_PUBLIC
                    ]
                ]
            ]);
    }
}