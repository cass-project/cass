<?php
namespace CASS\Domain\Bundles\Backdrop\Factory;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop\PresetBackdrop;

interface PresetFactory
{
    public function createPreset(string $id): PresetBackdrop;
    public function getListIds(): array;
}