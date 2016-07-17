<?php
namespace Domain\Index\Service\ThemeWeightCalculator;

use Domain\Profile\Entity\Profile;

final class ThemeWeightCalculator
{
    const BASE_WEIGHT = 1000;

    public function calculate(ThemeWeightEntity $entity): array
    {
        $result = [];
        $weight = self::BASE_WEIGHT /(count($entity->getThemeIds())<=0?1:count($entity->getThemeIds())) ;

        foreach($entity->getThemeIds() as $themeId) {
            $result[$themeId] = $weight;
        }

        return $result;
    }

    public function calculateProfileExpertWeight(Profile $profile): array
    {
        $ids = $profile->getExpertInIds();

        $result = [];
        $weight = self::BASE_WEIGHT / count($ids);

        foreach($ids as $themeId) {
            $result[$themeId] = $weight;
        }

        return $result;
    }

    public function calculateProfileInterestsWeight(Profile $profile): array
    {
        $ids = $profile->getInterestingInIds();

        $result = [];
        $weight = self::BASE_WEIGHT / count($ids);

        foreach($ids as $themeId) {
            $result[$themeId] = $weight;
        }

        return $result;
    }
}