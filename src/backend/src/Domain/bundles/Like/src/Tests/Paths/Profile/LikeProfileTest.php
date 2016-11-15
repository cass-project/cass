<?php
namespace CASS\Domain\Bundles\Like\Tests\Paths\Profile;

use CASS\Domain\Bundles\Like\Tests\LikeProfileMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class LikeProfileTest extends LikeProfileMiddlewareTestCase
{
    public function testProfile404()
    {
        $this->requestLikeProfile(self::NOT_FOUND_ID)
            ->execute()
            ->expectNotFoundError();
    }
}