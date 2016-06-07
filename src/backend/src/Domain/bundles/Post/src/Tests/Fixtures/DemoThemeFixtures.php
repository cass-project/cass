<?php
namespace Domain\Post\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Service\ThemeService;
use Zend\Expressive\Application;

class DemoThemeFixtures implements Fixture
{
    /** @var  Theme */
    private static $theme;

    public function up(Application $app, EntityManager $em) {
        $themeService = $app->getContainer()->get(ThemeService::class);
        self::$theme = $themeService->createTheme("test", "description", 0);
    }

    static public function getTheme(): Theme {
        return self::$theme;
    }
}