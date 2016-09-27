<?php
namespace CASS\Domain\Bundles\Profile\Backdrop\Preset;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop\PresetBackdrop;
use CASS\Domain\Bundles\Backdrop\Exception\PresetNotFoundException;
use CASS\Domain\Bundles\Backdrop\Factory\PresetFactory;

final class ProfileBackdropPresetFactory implements PresetFactory
{
    /** @var array  */
    private $json = [];

    public function __construct(array $json)
    {
        $this->json = $json;
    }

    public function getListIds(): array
    {
        return array_column($this->json, 'id');
    }

    public function createPreset(string $id): PresetBackdrop
    {
        $json = $this->findPresetJSON($id);

        return new PresetBackdrop(
            $id,
            $json['public_path'],
            $json['storage_path'],
            $json['text_color']
        );
    }

    private function findPresetJSON(string $id): array
    {
        foreach($this->json as $preset) {
            if($preset['id'] === $id) {
                return $preset;
            }
        }

        throw new PresetNotFoundException(sprintf('Preset with ID `%s` not found', $id));
    }
}