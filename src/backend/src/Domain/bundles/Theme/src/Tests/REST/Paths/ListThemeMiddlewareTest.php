<?php
namespace Domain\Theme\Tests\REST\Paths;

use Domain\Theme\Tests\ThemeMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class ListThemeMiddlewareTest extends ThemeMiddlewareTest
{
    public function testGetThemeList200()
    {
        $this->requestGetThemeList()->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
            ]);
    }
}