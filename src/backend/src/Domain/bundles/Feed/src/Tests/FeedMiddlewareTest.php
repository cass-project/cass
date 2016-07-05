<?php


namespace Domain\Feed\Tests;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;

/**
 * @backupGlobals disabled
 */
class FeedMiddlewareTest extends MiddlewareTestCase
{
    protected function getFixtures(): array{
        return [
        ];
    }

    public function testFeedCommunity404()
    {
        $json = [
           'criteria' => [
               'seek' => [
                   'limit' => 10,
                   'offset'=> 0
               ]
           ]
        ];

        return $this->requestFeedCommunity(999999,$json)->execute()
            ->expectJSONContentType()
             ->expectStatusCode(404)
            ;
    }

    public function requestFeedCommunity(int $communityId, $json)
    {
        return $this->request('POST', sprintf("/feed/community/%d/dashboard", $communityId))->setParameters($json);
    }

}