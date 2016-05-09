<?php
namespace Domain\Theme\Tests;

use Application\PHPUnit\Fixtures\DemoAccountFixture;
use Application\PHPUnit\Fixtures\DemoProfileFixture;
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

    private function assertThemeEquals(array $jsonExpected, array $jsonEntity, int $position) {
        $this->assertEquals($jsonExpected['title'], $jsonEntity['title']);
        $this->assertEquals($jsonExpected['description'], $jsonEntity['description']);
        $this->assertEquals($jsonExpected['parent_id'], $jsonEntity['parent_id']);
        $this->assertEquals($position, $jsonEntity['position']);
    }

    private function createTheme(array $json): Response {
        return $this->executeJSONRequest('/protected/theme/create', 'PUT', $json, [
            'x-api-key' => DemoAccountFixture::getAccount()->getAPIKey()
        ]);
    }

    public function testCreateRootThemeUnauthorizedNotAllowed() {
        $json = [
            'parent_id' => 0,
            'title' => 'My Demo Theme',
            'description' => 'My Demo Theme Description',
        ];

        $result = $this->executeJSONRequest('/protected/theme/create', 'PUT', $json);

        $this->assertEquals(403, $result->getStatusCode());
    }

    public function testCreateRootThemeSuccessWay() {
        $json = [
            'parent_id' => 0,
            'title' => 'My Demo Theme',
            'description' => 'My Demo Theme Description',
        ];

        $response = $this->createTheme($json);
        $output = $this->output;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $output['success']);
        $this->assertThemeEquals($json, $output['entity'], 1);
    }

    public function testCreateParentThemes() {
        $json = [
            1 => [
                'id' => 0 /* will be inserted */,
                'parent_id' => 0,
                'title' => 'Theme 1',
                'description' => 'My Theme 1'
            ],
            2 => [
                'id' => 0 /* will be inserted */,
                'parent_id' => 0,
                'title' => 'Theme 2',
                'description' => 'My Theme 2',
            ],
            3 => [
                'id' => 0 /* will be inserted */,
                'parent_id' => 0,
                'title' => 'Theme 3',
                'description' => 'My Theme 3'
            ],
            4 => [
                'id' => 0 /* will be inserted */,
                'parent_id' => 0,
                'title' => 'Theme 4',
                'description' => 'My Theme 4'
            ],
            5 => [
                'id' => 0 /* will be inserted */,
                'parent_id' => 0,
                'title' => 'Theme 5',
                'description' => 'My Theme 5'
            ]
        ];

        foreach($json as $position => $jsonEntity) {
            $response = $this->createTheme($jsonEntity);
            $output = $this->output;

            $this->assertEquals($response->getStatusCode(), 200);
            $this->assertEquals(true, $output['success']);
            $this->assertThemeEquals($jsonEntity, $output['entity'], $position);

            $json[$position]['id'] = $output['entity']['id'];
        }

        $jsonSubTheme2 = [
            1 => [
                'parent_id' => $json[2]['id'],
                'title' => 'Theme 2.1',
                'description' => 'My Theme 2.1'
            ],
            2 => [
                'parent_id' => $json[2]['id'],
                'title' => 'Theme 2.2',
                'description' => 'My Theme 2.2'
            ],
            3 => [
                'parent_id' => $json[2]['id'],
                'title' => 'Theme 2.3',
                'description' => 'My Theme 2.3'
            ],
            4 => [
                'parent_id' => $json[2]['id'],
                'title' => 'Theme 2.4',
                'description' => 'My Theme 2.4'
            ],
            5 => [
                'parent_id' => $json[2]['id'],
                'title' => 'Theme 2.5',
                'description' => 'My Theme 2.5'
            ]
        ];

        foreach($jsonSubTheme2 as $position => $jsonEntity) {
            $response = $this->createTheme($jsonEntity);
            $output = $this->output;

            $this->assertEquals($response->getStatusCode(), 200);
            $this->assertEquals(true, $output['success']);
            $this->assertThemeEquals($jsonEntity, $output['entity'], $position);

            $jsonSubTheme2[$position]['id'] = $output['entity']['id'];
        }

        $jsonSubTheme5 = [
            1 => [
                'parent_id' => $json[5]['id'],
                'title' => 'Theme 5.1',
                'description' => 'My Theme 5.1'
            ],
            2 => [
                'parent_id' => $json[5]['id'],
                'title' => 'Theme 5.2',
                'description' => 'My Theme 5.2'
            ],
            3 => [
                'parent_id' => $json[5]['id'],
                'title' => 'Theme 5.3',
                'description' => 'My Theme 5.3'
            ]
        ];

        foreach($jsonSubTheme5 as $position => $jsonEntity) {
            $response = $this->createTheme($jsonEntity);
            $output = $this->output;

            $this->assertEquals(200, $response->getStatusCode());
            $this->assertEquals(true, $output['success']);
            $this->assertThemeEquals($jsonEntity, $output['entity'], $position);

            $jsonSubTheme5[$position]['id'] = $output['entity']['id'];
        }
    }

    public function testGetThemeById() {
        $json = [
            'parent_id' => 0,
            'title' => 'My Demo Theme',
            'description' => 'My Demo Theme Description',
        ];

        $response = $this->createTheme($json);
        $output = $this->output;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $output['success']);
        $this->assertThemeEquals($json, $output['entity'], 1);

        $id = $output['entity']['id'];

        $response = $this->executeJSONRequest(sprintf('/theme/%d/get', $id), 'GET');
        $output = $this->output;

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals(true, $output['success']);
        $this->assertThemeEquals($json, $output['entity'], 1);
    }

    public function testGetThemeByIdNotFound() {
        $response = $this->executeJSONRequest(sprintf('/theme/%d/get', 18184), 'GET');
        $output = $this->output;

        $this->assertEquals($response->getStatusCode(), 404);
        $this->assertEquals(false, $output['success']);
    }

    public function testDeleteTheme() {
        // Создаем тему
        $json = [
            'parent_id' => 0,
            'title' => 'My Demo Theme',
            'description' => 'My Demo Theme Description',
        ];

        $response = $this->createTheme($json);
        $output = $this->output;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $output['success']);
        $this->assertThemeEquals($json, $output['entity'], 1);

        $id = $output['entity']['id'];

        // Тема создана, проверяем ее наличие
        $response = $this->executeJSONRequest(sprintf('/theme/%d/get', $id), 'GET');
        $output = $this->output;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $output['success']);
        $this->assertThemeEquals($json, $output['entity'], 1);

        // Not Authorized Expected
        $response = $this->executeJSONRequest(sprintf('/protected/theme/%d/delete', $id), 'DELETE');
        $this->assertEquals($response->getStatusCode(), 403);
        $this->assertEquals(true, $output['success']);

        // Success Delete
        $response = $this->executeJSONRequest(sprintf('/protected/theme/%d/delete', $id), 'DELETE', [], [
            'x-api-key' => DemoAccountFixture::getAccount()->getAPIKey()
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $output['success']);

        // Тема уже должна быть удалена и недоступна
        $response = $this->executeJSONRequest(sprintf('/theme/%d/get', $id), 'GET');
        $output = $this->output;

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(false, $output['success']);
    }
}