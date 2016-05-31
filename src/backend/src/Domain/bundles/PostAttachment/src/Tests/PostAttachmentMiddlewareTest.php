<?php


namespace Domain\PostAttachment\Tests;
use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class PostAttachmentMiddlewareTest extends MiddlewareTestCase
{
  protected function getFixtures(): array{
   return [];
  }

  public function testUpload403()
  {
    return $this->requestUpload()
      ->execute()->expectAuthError();
  }


  protected function requestUpload():RESTRequest
  {
    return $this->request('POST','/protected/post-attachment/upload');
  }



}