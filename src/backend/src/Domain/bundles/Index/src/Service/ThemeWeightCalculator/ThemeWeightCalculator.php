<?php
namespace CASS\Domain\Index\Service\ThemeWeightCalculator;

use CASS\Domain\Profile\Entity\Profile;
use CASS\Domain\Theme\Entity\Theme;
use CASS\Domain\Theme\Service\ThemeService;

final class ThemeWeightCalculator
{
    const MAX_THEMES = 10;
    const BASE_WEIGHT = 1000;

    /** @var ThemeService */
    private $themeService;

    public function __construct(ThemeService $themeService)
    {
        $this->themeService = $themeService;
    }

    public function calculateWeights(array $themeIds): array
    {
        if(count($themeIds) > 0) {
            $results = [];
            $baseWeight = self::BASE_WEIGHT / count($themeIds);

            foreach($themeIds as $rootThemeId) {
                $counter = 0;

                /** @var Theme $theme */
                foreach($this->iterateTheme($rootThemeId) as $theme) {
                    if(++$counter > self::MAX_THEMES) {
                        break;
                    }

                    $results[] = new ThemeWeightResult($theme->getId(), $baseWeight);
                    $baseWeight = (int) ($baseWeight / 2);
                }
            }

            return $this->resultsToMap($results);
        }else{
            return [];
        }
    }

    private function iterateTheme(int $rootThemeId)
    {
        do {
            $theme = $this->themeService->getThemeById($rootThemeId);

            if($theme->hasParent()) {
                $rootThemeId = $theme->getParent()->getId();
            }

            yield $theme;
        } while($theme->hasParent());
    }

    private function lookupThemeTree(int $themeId, int $baseWeight): array
    {
        $merge = [(string) $themeId => $baseWeight];
        $theme = $this->themeService->getThemeById($themeId);

        if($theme->hasParent()) {
            $merge = array_merge($merge, $this->lookupThemeTree($theme->getParentId(), (int) ($baseWeight / 2)));
        }

        return $merge;
    }

    private function resultsToMap(array $results) {
        $map = [];

        array_map(function(ThemeWeightResult $result) use (&$map) {
            $map[$result->getThemeId()] = $result->getWeight();
        }, $results);

        return $map;
    }
}