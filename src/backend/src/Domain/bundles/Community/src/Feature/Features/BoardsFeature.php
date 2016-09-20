<?php
namespace CASS\Domain\Bundles\Community\Feature\Features;

use CASS\Domain\Bundles\Community\Entity\Community;

final class BoardsFeature extends AbstractFeature
{
    const FEATURE_CODE = 'boards';

    public static function getCode(): string
    {
        return self::FEATURE_CODE;
    }

    static public function getFACode(): string
    {
        return 'fa-bookmark';
    }

    public function getTranslatedName(): string
    {
        return 'Форум';
    }

    public function getTranslatedDescription(): string
    {
        return 'Доска объявлений, система форумов для вашего сообщества';
    }

    public function isProductionReady(): bool
    {
        return false;
    }

    public function isDevelopmentReady(): bool
    {
        return false;
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