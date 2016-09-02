<?php
namespace CASS\Domain\Avatar\Image;

use CASS\Util\JSONSerializable;

class Image implements JSONSerializable
{
    /** @var string */
    private $storagePath;

    /** @var string */
    private $publicPath;

    public function __construct(string $storagePath, string $publicPath)
    {
        $this->storagePath = $storagePath;
        $this->publicPath = $publicPath;
    }

    public function toJSON(): array {
        return [
            'storage_path' => $this->getStoragePath(),
            'public_path' => $this->getPublicPath(),
        ];
    }

    public function getStoragePath(): string
    {
        return $this->storagePath;
    }

    public function getPublicPath(): string
    {
        return $this->publicPath;
    }
}