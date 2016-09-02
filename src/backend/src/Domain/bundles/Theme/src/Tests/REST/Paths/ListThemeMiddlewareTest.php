<?php
namespace CASS\Domain\Theme\Tests\REST\Paths;

use CASS\Domain\Theme\Tests\ThemeMiddlewareTest;

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