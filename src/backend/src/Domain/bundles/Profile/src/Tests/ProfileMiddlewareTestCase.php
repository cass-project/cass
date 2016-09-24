<?php
namespace CASS\Domain\Bundles\Profile\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use ZEA2\Platform\Bundles\PHPUnit\RESTRequest\RESTRequest;
use CASS\Util\Definitions\Point;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use Zend\Diactoros\UploadedFile;

/**
 * @backupGlobals disabled
 */
abstract class ProfileMiddlewareTestCase extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture()
        ];
    }

    protected function requestCreateProfile(): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/profile/create'));
    }

    protected function requestGetProfile(int $profileId): RESTRequest
    {
        return $this->request('GET', sprintf('/profile/%d/get', $profileId));
    }

    protected function requestGetProfileBySID(string $profileSID): RESTRequest
    {
        return $this->request('GET', sprintf('/profile/by-sid/%s/get', $profileSID));
    }

    protected function requestDeleteProfile(int $profileId): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/profile/%d/delete', $profileId));
    }

    protected function requestEditPersonal(int $profileId, array $json): RESTRequest
    {
        return $this->request('POST', sprintf('/protected/profile/%d/edit-personal', $profileId))
            ->setParameters($json);
    }

    protected function requestSwitch(int $profileId): RESTRequest
    {
        return $this->request('POST', sprintf('/protected/profile/%d/switch', $profileId));
    }

    protected function requestUploadImage(int $profileId, Point $start, Point $end, string $localFile): RESTRequest
    {
        $uri = sprintf(
            '/protected/profile/%d/image-upload/crop-start/%d/%d/crop-end/%d/%d',
            $profileId,
            $start->getX(),
            $start->getY(),
            $end->getX(),
            $end->getY()
        );

        $this->assertTrue(is_readable($localFile));

        return $this->request('POST', $uri)
            ->setUploadedFiles([
                'file' => new UploadedFile($localFile, filesize($localFile), 0)
            ]);
    }

    protected function requestDeleteImage(int $profileId): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/profile/%d/image-delete', $profileId));
    }

    protected function requestInterestingInPUT(int $profileId, array $json): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/profile/%d/interesting-in', $profileId))
            ->setParameters($json);
    }

    protected function requestExpertInPUT(int $profileId, array $json): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/profile/%d/expert-in', $profileId))
            ->setParameters($json);
    }

    protected function requestSetBirthday(int $profileId, array $json): RESTRequest
    {
        return $this->request('POST', sprintf('/protected/profile/%d/birthday', $profileId))
            ->setParameters($json);
    }

    protected function requestUnsetBirthday(int $profileId): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/profile/%d/birthday', $profileId));
    }

    protected function requestBackdropUpload(int $profileId, string $localFile, string $textColor): RESTRequest
    {
        $url = sprintf('/protected/profile/%d/backdrop-upload/textColor/%s', $profileId, $textColor);

        return $this->request('POST', $url)
            ->setUploadedFiles([
                'file' => new UploadedFile($localFile, filesize($localFile), 0)
            ]);
    }

    protected function fromNow(int $years): \DateTime
    {
        if($years > 0) {
            return (new \DateTime())->add(
                new \DateInterval(sprintf('P%dY', abs($years)))
            );
        }else{
            return (new \DateTime())->sub(
                new \DateInterval(sprintf('P%dY', abs($years)))
            );
        }
    }
}