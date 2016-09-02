<?php
namespace CASS\Domain\Bundles\Community\Feature\Features;

use CASS\Domain\Bundles\Community\Entity\Community;

final class CollectionsFeature extends AbstractFeature
{
    const FEATURE_CODE = 'collections';

    public static function getCode(): string
    {
        return self::FEATURE_CODE;
    }

    static public function getFACode(): string
    {
        return 'fa-bookmark';
    }

    public function isProductionReady(): bool
    {
        return true;
    }

    public function isDevelopmentReady(): bool
    {
        return true;
    }

    public function activate(Community $community)
    {
        return true;
    }

    public function deactivate(Community $community)
    {
        return true;
    }
}