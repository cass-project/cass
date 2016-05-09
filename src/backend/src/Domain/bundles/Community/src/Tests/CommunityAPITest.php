<?php
namespace Domain\Community\Tests;

use Application\Util\Definitions\Point;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;
use Zend\Diactoros\UploadedFile;
use Zend\Stratigility\Http\Response;

/**
 * @backupGlobals disabled
 */
class CommunityAPITests extends MiddlewareTestCase
{
    protected function getFixtures(): array {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
        ];
    }

    private function createCommunity(array $json): int {
        $response = $this->executeJSONRequest('/protected/community/create', 'PUT', $json, ['x-api-key' => DemoAccountFixture::getAccount()->getAPIKey()]);
        $output = $this->output;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $output['success']);
        $this->assertArrayHasKey('id', $output['entity']);
        $this->assertEquals($json['title'], $output['entity']['title']);
        $this->assertEquals($json['description'], $output['entity']['description']);
        $this->assertEquals($json['theme_id'], $output['entity']['theme_id']);

        return $output['entity']['id'];
    }
    
    private function uploadImage(int $communityId, Point $start, Point $end): Response {
        $url = "/protected/community/{$communityId}/image-upload/crop-start/{$start->getX()}/{$start->getY()}/crop-end/{$end->getX()}/{$end->getY()}/";

        $fileName = __DIR__.'/resources/grid-example.png';
        $uploadedFile = new UploadedFile($fileName, filesize($fileName), 0);

        return $this->executeJSONRequest($url, 'POST', [], [
            'x-api-key' => DemoAccountFixture::getAccount()->getAPIKey(),
            'uploadedFiles' => [
                'file' => $uploadedFile
            ]
        ]);
    }

    private function getCommunityById(int $communityId, array $json) {
        $response = $this->executeJSONRequest(sprintf('/community/%d/get', $communityId), 'GET');
        $output = $this->output;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $output['success']);
        $this->assertEquals($communityId, $output['entity']['id']);
        $this->assertEquals($json['title'], $output['entity']['title']);
        $this->assertEquals($json['description'], $output['entity']['description']);
        $this->assertEquals($json['theme_id'], $output['entity']['theme_id']);
    }

    private function editCommunity(int $communityId, array $json) {
        $response = $this->executeJSONRequest(
            sprintf('/protected/community/%d/edit', $communityId),
            'POST',
            $json,
            ['x-api-key' => DemoAccountFixture::getAccount()->getAPIKey()]
        );
        $output = $this->output;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $output['success']);
        $this->assertArrayHasKey('id', $output['entity']);
        $this->assertEquals($communityId, $output['entity']['id']);
        $this->assertEquals($json['title'], $output['entity']['title']);
        $this->assertEquals($json['description'], $output['entity']['description']);
        $this->assertEquals($json['theme_id'], $output['entity']['theme_id']);
    }

    public function testCreateCommunityNotAuthorized() {
        $theme = SampleThemesFixture::getThemes()['themes_root'][1]; /** @var Theme $theme */
        $response = $this->executeJSONRequest('/protected/community/create', 'PUT', [
            'title' => 'Community 1',
            'description' => 'My Community 1',
            'theme_id' => $theme->getId()
        ]);

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals(false, $this->output['success']);
    }

    public function testCreateCommunitySuccessWay() {
        $theme = SampleThemesFixture::getThemes()['themes_root'][1]; /** @var Theme $theme */
        $json = [
            'title' => 'Community 1',
            'description' => 'My Community 1',
            'theme_id' => $theme->getId()
        ];

        $this->createCommunity($json);
    }

    public function testEditCommunitySuccessWay() {
        $theme = SampleThemesFixture::getThemes()['themes_root'][1]; /** @var Theme $theme */
        $json = [
            'title' => 'Community 1',
            'description' => 'My Community 1',
            'theme_id' => $theme->getId()
        ];

        /** @var Theme $sTheme */
        $sTheme = SampleThemesFixture::getThemes()['themes_root'][2];
        $communityId = $this->createCommunity($json);
        $this->editCommunity($communityId, [
            'title' => '* Community 1',
            'description' => '* My Community 1',
            'theme_id' => $sTheme->getId()
        ]);
    }

    public function testGetById() {
        $theme = SampleThemesFixture::getThemes()['themes_root'][1]; /** @var Theme $theme */
        $json = [
            'title' => 'Community 1',
            'description' => 'My Community 1',
            'theme_id' => $theme->getId()
        ];

        $communityId = $this->createCommunity($json);
        $this->getCommunityById($communityId, $json);
    }

    public function testUploadImageSuccessWay() {
        $theme = SampleThemesFixture::getThemes()['themes_root'][1]; /** @var Theme $theme */
        $json = [
            'title' => 'Community 1',
            'description' => 'My Community 1',
            'theme_id' => $theme->getId()
        ];

        $communityId = $this->createCommunity($json);
        $response = $this->uploadImage($communityId, new Point(0, 0), new Point(200, 200));
        $output = $this->output;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $output['success']);
        $this->assertArrayHasKey('image', $output);
        $this->assertArrayHasKey('public_path', $output['image']);
    }

    public function testUploadImageTooBig() {
        $theme = SampleThemesFixture::getThemes()['themes_root'][1]; /** @var Theme $theme */
        $json = [
            'title' => 'Community 1',
            'description' => 'My Community 1',
            'theme_id' => $theme->getId()
        ];

        $communityId = $this->createCommunity($json);
        $response = $this->uploadImage($communityId, new Point(0, 0), new Point(1024, 1024));
        $output = $this->output;

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals(false, $output['success']);
    }
}