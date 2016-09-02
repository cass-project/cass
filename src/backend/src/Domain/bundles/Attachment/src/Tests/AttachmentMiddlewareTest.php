<?php
namespace Domain\Attachment\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use ZEA2\Platform\Bundles\PHPUnit\RESTRequest\RESTRequest;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Zend\Diactoros\UploadedFile;

/**
 * @backupGlobals disabled
 */
class AttachmentMiddlewareTest extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
        ];
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

    public function testUpload200()
    {
        $localFileName = __DIR__ . '/Resources/grid-example.png';
        $uploadFile = new UploadedFile($localFileName, filesize($localFileName), 0);

        return $this->requestUpload($uploadFile)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ])
            ->expectJSONBody([
                'entity' => [
                    'id' => $this->expectId(),
                    'sid' => $this->expectString(),
                    'date_created_on' => $this->expectString(),
                    'metadata' => [
                        'url' => $this->expectString(),
                        'resource' => $this->expectString(),
                        'source' => [
                            'source' => 'local',
                            'public_path' => $this->expectString(),
                            'storage_path' => $this->expectString(),
                        ],
                    ],
                    'is_attached' => false,
                ],
            ]);
    }

    protected function requestUpload(UploadedFile $localFile): RESTRequest
    {
        return $this
            ->request('POST', '/protected/attachment/upload')
            ->setUploadedFiles([
                'file' => $localFile,
            ]);
    }
}