<?php
namespace Domain\Colors\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use Domain\Colors\Entity\Color;

/**
 * @backupGlobals disabled
 */
class ColorsMiddlewareTest extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array {
        return [];
    }

    private function requestGetColors() {
        return $this->request('GET', '/colors/get-colors');
    }

    private function requestGetPalettes() {
        return $this->request('GET', '/colors/get-palettes');
    }

    public function testGetColors() {
        $this->requestGetColors()
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expect(function(array $response) {
                $this->assertTrue(is_array($response));
                $this->assertTrue(isset($response['colors']));

                foreach($response['colors'] as $code => $properties) {
                    $this->assertTrue(is_string($code));
                    $this->assertGreaterThan(0, strlen($code));
                    $this->colorAsserts($properties);
                    $this->assertEquals($code, $properties['code']);
                }
            });
    }

    public function testGetPalettes() {
        $this->requestGetPalettes()
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expect(function(array $response) {
                $this->assertTrue(is_array($response));
                $this->assertTrue(isset($response['palettes']));

                foreach($response['palettes'] as $code => $palette) {
                    $this->assertTrue(is_string($code));
                    $this->assertGreaterThan(0, strlen($code));
                    $this->assertEquals($code, $palette['code']);
                    $this->assertTrue(isset($palette['background']) && is_array($palette['background']));
                    $this->colorAsserts($palette['background']);
                    $this->assertTrue(isset($palette['foreground']) && is_array($palette['foreground']));
                    $this->colorAsserts($palette['foreground']);
                    $this->assertTrue(isset($palette['border']) && is_array($palette['border']));
                    $this->colorAsserts($palette['border']);
                }
            });
    }

    private function colorAsserts(array $properties) {
        $this->assertTrue(is_array($properties));
        $this->assertTrue(isset($properties['code']));
        $this->assertTrue(is_string($properties['code']));
        $this->assertTrue(isset($properties['hexCode']));
        $this->assertTrue(is_string($properties['hexCode']));
        $this->assertTrue((bool) preg_match(Color::REGEX_COLOR, $properties['hexCode']));
    }
}