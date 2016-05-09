<?php
namespace Domain\Theme\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Theme\Service\ThemeService;
use Zend\Expressive\Application;

class SampleThemeFixtures implements Fixture
{
    public function up(Application $app, EntityManager $em) {
        $themeService = $app->getContainer()->get(ThemeService::class); /** @var ThemeService $themeService */
        
        $themes = [
            1 => $themeService->createTheme('Theme 1', 'My Theme 1'),
            2 => $themeService->createTheme('Theme 2', 'My Theme 2'),
            3 => $themeService->createTheme('Theme 3', 'My Theme 3'),
            4 => $themeService->createTheme('Theme 4', 'My Theme 4'),
            5 => $themeService->createTheme('Theme 5', 'My Theme 5'),
        ];
        
        $subThemes2 = [
            1 => $themeService->createTheme('Theme 2.1', 'My Theme 2.1', $themes[2]->getId()),
            2 => $themeService->createTheme('Theme 2.2', 'My Theme 2.2', $themes[2]->getId()),
            3 => $themeService->createTheme('Theme 2.3', 'My Theme 2.3', $themes[2]->getId()),
        ];

        $subThemes23 = [
            1 => $themeService->createTheme('Theme 2.3.1', 'My Theme 2.3.1', $subThemes2[3]->getId()),
            2 => $themeService->createTheme('Theme 2.3.2', 'My Theme 2.3.2', $subThemes2[3]->getId()),
            3 => $themeService->createTheme('Theme 2.3.3', 'My Theme 2.3.3', $subThemes2[3]->getId()),
        ];
        
        $subThemes5 = [
            1 => $themeService->createTheme('Theme 5.1', 'My Theme 5.1', $themes[5]->getId()),
            2 => $themeService->createTheme('Theme 5.2', 'My Theme 5.2', $themes[5]->getId()),
            3 => $themeService->createTheme('Theme 5.3', 'My Theme 5.3', $themes[5]->getId()),
        ];
    }
}