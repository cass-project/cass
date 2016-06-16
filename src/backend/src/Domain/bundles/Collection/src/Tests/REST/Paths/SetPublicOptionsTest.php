<?php
namespace Domain\Collection\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use Domain\Collection\Tests\REST\CollectionRESTTestCase;

/**
 * @backupGlobals disabled
 */
final class SetPublicOptionsTest extends CollectionRESTTestCase
{
    public function test200()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $collection = SampleCollectionsFixture::getCommunityCollection(1);
        $options = [
            'is_private' => false,
            'public_enabled' => true,
            'moderation_contract' => true
        ];

        $this->requestSetPublicOptions($collection->getId(), $options)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ]);
    }

    public function test403()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $collection = SampleCollectionsFixture::getCommunityCollection(1);
        $options = [
            'is_private' => false,
            'public_enabled' => true,
            'moderation_contract' => true
        ];

        $this->requestSetPublicOptions($collection->getId(), $options)
            ->execute()
            ->expectAuthError();
    }

    public function test404()
    {
        $options = [
            'is_private' => false,
            'public_enabled' => true,
            'moderation_contract' => true
        ];

        $this->requestSetPublicOptions(999999999, $options)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function test409_private_and_public_enabled()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $collection = SampleCollectionsFixture::getCommunityCollection(1);
        $options = [
            'is_private' => true,
            'public_enabled' => true,
            'moderation_contract' => true
        ];

        $this->requestSetPublicOptions($collection->getId(), $options)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString()
            ]);
    }
}