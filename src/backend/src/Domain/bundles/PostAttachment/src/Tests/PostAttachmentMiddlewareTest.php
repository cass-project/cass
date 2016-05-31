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
    $localFile = __DIR__.'/Resources/grid-example.png';

    return $this->requestUpload($localFile)
                ->auth(DemoAccountFixture::getAccount()->getAPIKey())
                ->execute()
      ->expectStatusCode(200)
      ->expectJSONContentType()
      ->expectJSONBody(['success' => true,])

      ;
  }

  public function testUpload403()
  {
    $localFile = __DIR__.'/Resources/grid-example.png';

    return $this->requestUpload($localFile)
      ->execute()->expectAuthError();
  }


  protected function requestUpload($localFile):RESTRequest
  {
    return $this->request('POST','/protected/post-attachment/upload')
      ->setUploadedFiles([
                           'file' => new UploadedFile($localFile, filesize($localFile), 0)
                         ]);
  }



}