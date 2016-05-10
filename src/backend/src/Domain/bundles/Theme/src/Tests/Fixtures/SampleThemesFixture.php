<?php
namespace Domain\Theme\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Service\ThemeService;
use Zend\Expressive\Application;

class SampleThemesFixture implements Fixture
{
    private static $themes;

    public function up(Application $app, EntityManager $em) {
        $themeService = $app->getContainer()->get(ThemeService::class); /** @var ThemeService $themeService */
        
        self::$themes = [
            1 => $themeService->createTheme('Theme 1', 'My Theme 1'),
            2 => $themeService->createTheme('Theme 2', 'My Theme 2'),
            3 => $themeService->createTheme('Theme 3', 'My Theme 3'),
            4 => $themeService->createTheme('Theme 4', 'My Theme 4'),
            5 => $themeService->createTheme('Theme 5', 'My Theme 5'),
        ];
    }

    public static function getThemes(): array {
        return self::$themes;
    }

    public static function getTheme(int $index): Theme {
        return self::$themes[$index];
    }
}