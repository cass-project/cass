<?php
namespace Domain\Theme;

use Application\Frontline\FrontlineBundleInjectable;
use Application\Bundle\GenericBundle;
use DI\Container;
use Application\Frontline\Service\FrontlineService;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Service\ThemeService;

class ThemeBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function initFrontline(Container $container, FrontlineService $frontlineService) {
        $themeService = $container->get(ThemeService::class); /** @var ThemeService $themeService */

        $frontlineService::$exporters->addExporter('themes', function() use ($themeService) {
            return [
                'themes' => $this->buildJSON($themeService->getThemesAsTree())
            ];
        });
    }

    private function buildJSON(array $themes) {
        return array_map(function(Theme $theme) {
            $result = $theme->toJSON();
            $result['children'] = $theme->hasChildren() ? $this->buildJSON($theme->getChildren()->toArray()) : [];

            return $result;
        }, $themes);
    }
}