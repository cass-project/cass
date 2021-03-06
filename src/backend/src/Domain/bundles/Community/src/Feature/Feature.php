<?php
namespace CASS\Domain\Bundles\Community\Feature;

use CASS\Domain\Bundles\Community\Entity\Community;

interface Feature
{
    static public function getCode(): string;
    static public function getFACode(): string;

    public function getTranslatedName(): string;
    public function getTranslatedDescription(): string;
    public function isProductionReady(): bool;
    public function isDevelopmentReady(): bool;
    public function isActivated(Community $community): bool;
    public function activate(Community $community);
    public function deactivate(Community $community);
}