<?php
namespace CASS\Application\Bundles\Version\Tests;
use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
final class VersionMiddlewareTest extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [];
    }

    public function testVersion()
    {
        $this->request('GET', '/version')
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'version' => $this->expectString(),
            ])
            ->expect(function(array $json) {
                $this->assertEquals(1, preg_match('/\d{1}\.\d{1,5}\.\d{1,5}/', $json['version']));
                $this->assertTrue(isset($json['blacklist']));
                $this->assertTrue(is_array($json['blacklist']));
            });
    }
}