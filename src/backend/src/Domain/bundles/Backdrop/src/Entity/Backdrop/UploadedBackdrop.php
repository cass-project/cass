<?php
namespace CASS\Domain\Bundles\Backdrop\Entity\Backdrop;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop;
use CASS\Domain\Bundles\Colors\Entity\Color;

final class UploadedBackdrop implements Backdrop
{
    const TYPE_ID = 'uploaded';

    /** @var string */
    private $storagePath;

    /** @var string */
    private $publicPath;

    /** @var string */
    private $textColor;

    public function __construct(string $storagePath, string $publicPath, string $textColor)
    {
        $this->storagePath = $storagePath;
        $this->publicPath = $publicPath;
        $this->textColor = $textColor;
    }

    public function getType(): string
    {
        return self::TYPE_ID;
    }

    public function getStoragePath(): string
    {
        return $this->storagePath;
    }

    public function getPublicPath(): string
    {
        return $this->publicPath;
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
                'storage_path' => $this->getStoragePath(),
                'public_path' => $this->getPublicPath(),
                'text_color' => $this->getTextColor(),
            ],
        ];
    }
}