<?php
namespace CASS\Domain\Bundles\Community\Feature\Features;

use CASS\Domain\Bundles\Community\Entity\Community;

final class ChatFeature extends AbstractFeature
{
    const FEATURE_CODE = 'chat';

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
        return 'Чат';
    }

    public function getTranslatedDescription(): string
    {
        return 'Добавляет возможность вести коллективные чаты в ваше сообщество';
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