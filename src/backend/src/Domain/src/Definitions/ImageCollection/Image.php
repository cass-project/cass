<?php
namespace Domain\Definitions\ImageCollection;

use Application\Util\JSONSerializable;

class Image implements JSONSerializable
{
    /** @var string */
    private $storagePath;

    /** @var string */
    private $publicPath;

    public function __construct(string $storagePath, string $publicPath)
    {
        if(! (is_file($storagePath) && file_exists($storagePath))) {
            throw new \Exception(sprintf('File `%s` does\'nt exists', $storagePath));
        }

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