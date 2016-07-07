<?php


namespace Domain\Feed\Tests;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Post\Tests\Fixtures\SamplePostsFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class FeedMiddlewareTest extends MiddlewareTestCase
{
    private $criteria_json = [
        'criteria' => [
            'seek' => [
                'limit' => 10,
                'offset'=> 0
            ]
        ]
    ];


    protected function getFixtures(): array{
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),

            new SampleCommunitiesFixture(),
            new SampleCollectionsFixture(),
            new SamplePostsFixture()
        ];
    }

    public function testFeedCommunity404()
    {
        return $this->requestFeedCommunity(999999, $this->criteria_json)->execute()
            ->expectJSONContentType()
             ->expectStatusCode(404)
            ;
    }


    public function testFeedProfile200()
    {
        $profileId = DemoAccountFixture::getAccount()->getCurrentProfile()->getId();

        return $this->requestFeedProfile($profileId, $this->criteria_json)->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200);
    }

    public function testFeedProfile404()
    {
        return $this->requestFeedProfile(999999, $this->criteria_json)->execute()
                    ->expectJSONContentType()
                    ->expectStatusCode(404)
            ;
    }

    public function requestFeedCommunity(int $communityId, $json)
    {
        return $this->request('POST', sprintf("/feed/community/%d/dashboard", $communityId))->setParameters($json);
    }

    public function requestFeedProfile(int $profileId, array $json){
        return $this->request('POST', sprintf('/feed/profile/%d/dashboard', $profileId))->setParameters($json);
    }

}