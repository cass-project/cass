<?php
namespace Domain\PostAttachment\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\PostAttachment\Entity\PostAttachment\File\ImageAttachmentType;
use Zend\Diactoros\UploadedFile;

/**
 * @backupGlobals disabled
 */
class PostAttachmentMiddlewareTest extends MiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture()
        ];
    }

    public function testUpload200()
    {
        $localFileName = __DIR__ . '/Resources/grid-example.png';
        $uploadFile = new UploadedFile($localFileName, filesize($localFileName), 0);

        return $this->requestUpload($uploadFile)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody(['success' => true]);
    }

    public function testUpload403()
    {
        $localFileName = __DIR__ . '/Resources/grid-example.png';
        $uploadFile = new UploadedFile($localFileName, filesize($localFileName), 0);

        return $this
            ->requestUpload($uploadFile)
            ->execute()
            ->expectAuthError();
    }

    protected function requestUpload(UploadedFile $localFile):RESTRequest
    {
        return $this
            ->request('POST', '/protected/post-attachment/upload')
            ->setUploadedFiles([
                'file' => $localFile
            ]);
    }
}