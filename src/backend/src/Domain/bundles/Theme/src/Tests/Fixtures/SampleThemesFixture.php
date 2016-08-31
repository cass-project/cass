<?php
namespace Domain\Theme\Tests\Fixtures;

use CASS\Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Parameters\CreateThemeParameters;
use Domain\Theme\Service\ThemeService;
use Zend\Expressive\Application;

class SampleThemesFixture implements Fixture
{
    private static $themes;

    public function up(Application $app, EntityManager $em) {
        $themeService = $app->getContainer()->get(ThemeService::class); /** @var ThemeService $themeService */
        
        self::$themes = [
            1 => $themeService->createTheme(new CreateThemeParameters('Theme 1', 'My Theme 1')),
            2 => $themeService->createTheme(new CreateThemeParameters('Theme 2', 'My Theme 2')),
            3 => $themeService->createTheme(new CreateThemeParameters('Theme 3', 'My Theme 3')),
            4 => $themeService->createTheme(new CreateThemeParameters('Theme 4', 'My Theme 4')),
            5 => $themeService->createTheme(new CreateThemeParameters('Theme 5', 'My Theme 5')),
        ];
    }

    public static function getThemes(): array {
        return self::$themes;
    }

    public static function getTheme(int $index): Theme {
        return self::$themes[$index];
    }
}