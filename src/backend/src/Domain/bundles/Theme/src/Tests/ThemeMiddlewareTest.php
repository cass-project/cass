<?php
namespace Domain\Theme\Tests;

use Application\PHPUnit\RESTRequest\Request;
use Application\PHPUnit\RESTRequest\Result;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Zend\Stratigility\Http\Response;

/**
 * @backupGlobals disabled
 */
class ThemeMiddlewareTest extends MiddlewareTestCase
{
    protected function getFixtures(): array {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture()
        ];
    }

    public function testCreateTheme() {
        $json = [
            'title' => 'Theme 1',
            'description' => 'My Demo Theme Descrition',
            'parent_id' => 0
        ];

        $this->requestCreateTheme($json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'title' => $json['title'],
                    'parent_id' => null,
                    'description' => $json['description']
                ]
            ])
        ;
    }

    private function requestCreateTheme(array $json): Request {
        return $this->request('PUT', '/protected/theme/create')
            ->setParameters($json)
        ;
    }
}