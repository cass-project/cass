<?php
namespace CASS\Domain\Bundles\Backdrop\Entity\Backdrop;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop;
use CASS\Domain\Bundles\Colors\Entity\Color;

final class PresetBackdrop implements Backdrop
{
    const TYPE_ID = 'preset';

    /** @var string */
    private $presetId;

    /** @var string */
    private $publicPath;

    /** @var string */
    private $storagePath;

    /** @var string */
    private $textColor;

    public function __construct(
        string $presetId,
        string $publicPath,
        string $storagePath,
        string $textColor
    ) {
        $this->presetId = $presetId;
        $this->publicPath = $publicPath;
        $this->storagePath = $storagePath;
        $this->textColor = $textColor;
    }

    public function getType(): string
    {
        return self::TYPE_ID;
    }

    public function getPresetId(): string
    {
        return $this->presetId;
    }

    public function getPublicPath(): string
    {
        return $this->publicPath;
    }

    public function getStoragePath(): string
    {
        return $this->storagePath;
    }

    public function getTextColor(): string
    {

        return $this->textColor;
    }

    public function toJSON(): array
    {
        return [
            'type' => $this->getType(),
            'metadata' => [
                'preset_id' => $this->getPresetId(),
                'public_path' => $this->getPublicPath(),
                'storage_path' => $this->getStoragePath(),
                'text_color' => $this-$this->getTextColor(),
            ],
        ];
    }
}