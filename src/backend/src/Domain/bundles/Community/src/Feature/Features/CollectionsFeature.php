<?php
namespace Domain\Community\Feature\Features;

use Domain\Community\Entity\Community;

final class CollectionsFeature extends AbstractFeature
{
    const FEATURE_CODE = 'collections';

    public static function getCode(): string
    {
        return self::FEATURE_CODE;
    }

    public function isProductionReady(): bool
    {
        return true;
    }

    public function isDevelopmentReady(): bool
    {
        return true;
    }
}