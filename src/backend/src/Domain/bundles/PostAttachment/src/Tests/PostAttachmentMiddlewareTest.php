<?php


namespace Domain\PostAttachment\Tests;
use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Zend\Diactoros\UploadedFile;

/**
 * @backupGlobals disabled
 */
class PostAttachmentMiddlewareTest extends MiddlewareTestCase
{
  protected function getFixtures(): array{
   return [
     new DemoAccountFixture()
   ];
  }

  public function testUpload200()
  {
    $localFilepath = __DIR__.'/Resources/grid-example.png';

    $localFile = new UploadedFile($localFilepath, filesize($localFilepath), 0);
    return $this->requestUpload($localFile)
                ->auth(DemoAccountFixture::getAccount()->getAPIKey())
                ->execute()
      ->expectStatusCode(200)
      ->expectJSONContentType()
      ->expectJSONBody(['success' => true,])

      ;
  }
  public function testUploadBigFile409()
  {
    $localFile = __DIR__.'/Resources/grid-example.png';

    $localFile = new UploadedFile($localFile, 1024*1024*32+1000, 0);

    return $this->requestUpload($localFile)
                ->auth(DemoAccountFixture::getAccount()->getAPIKey())
                ->execute()
      ->expectStatusCode(409)
      ->expectJSONContentType()
      ->expectJSONBody(['success' => false,])
      ;
  }
  public function testUploadSmallFile409()
  {
    $localFile = __DIR__.'/Resources/grid-example.png';

    $localFile = new UploadedFile($localFile, 0, 0);

    return $this->requestUpload($localFile)
                ->auth(DemoAccountFixture::getAccount()->getAPIKey())
                ->execute()
      ->expectStatusCode(409)
      ->expectJSONContentType()
      ->expectJSONBody(['success' => false,])
      ;
  }

  public function testUpload403()
  {
    $localFile = __DIR__.'/Resources/grid-example.png';

    $localFile = new UploadedFile($localFile, filesize($localFile), 0);

    return $this->requestUpload($localFile)
      ->execute()->expectAuthError();
  }


  protected function requestUpload( UploadedFile $localFile):RESTRequest
  {
    return $this->request('POST','/protected/post-attachment/upload')
      ->setUploadedFiles([
                           'file' => $localFile
                         ]);
  }
}