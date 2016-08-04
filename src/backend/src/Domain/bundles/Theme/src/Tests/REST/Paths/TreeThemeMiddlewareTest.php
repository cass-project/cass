<?php
namespace Domain\Theme\Tests\REST\Paths;

use Domain\Theme\Tests\ThemeMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class TreeThemeMiddlewareTest extends ThemeMiddlewareTest
{
    public function testGetThemeTree200()
    {
        $this->requestGetThemeTree()
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
            ]);
    }
}