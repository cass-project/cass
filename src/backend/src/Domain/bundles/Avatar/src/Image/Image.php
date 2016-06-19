<?php
namespace Domain\Avatar\Image;

use Application\Util\JSONSerializable;

class Image implements JSONSerializable
{
    /** @var string */
    private $storagePath;

    /** @var string */
    private $publicPath;

    /** @var string */
    private $md5;

    public function __construct(string $storagePath, string $publicPath)
    {
        if(! (is_file($storagePath) && file_exists($storagePath))) {
            throw new \Exception(sprintf('File `%s` does\'nt exists', $storagePath));
        }

        $this->storagePath = $storagePath;
        $this->publicPath = $publicPath;
        $this->md5 = md5_file($this->storagePath);
    }

    public function toJSON(): array {
        return [
            'md5' => $this->getMD5(),
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

    public function getMD5(): string
    {
        return $this->md5;
    }
}