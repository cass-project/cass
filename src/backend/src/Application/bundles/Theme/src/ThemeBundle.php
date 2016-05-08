<?php
namespace Application\Theme;

use Application\Common\Bootstrap\Bundle\FrontlineBundleInjectable;
use Application\Common\Bootstrap\Bundle\GenericBundle;
use DI\Container;
use Application\Frontline\Service\FrontlineService;
use Application\Theme\Entity\Theme;
use Application\Theme\Service\ThemeService;

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