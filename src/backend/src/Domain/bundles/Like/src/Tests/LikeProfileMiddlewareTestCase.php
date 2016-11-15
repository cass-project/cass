<?php
namespace CASS\Domain\Bundles\Like\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;


/**
 * @backupGlobals disabled
 */
class LikeProfileMiddlewareTestCase extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array{
        return [];
    }

    public function requestLikeProfile(int $profileId){
        return $this->request('PUT', sprintf('/like/profile/%d/add-like', $profileId));
    }

}