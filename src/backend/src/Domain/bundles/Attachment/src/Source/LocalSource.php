<?php
namespace CASS\Domain\Attachment\Source;

final class LocalSource implements Source
{
    const SOURCE_CODE = 'local';

    /** @var string */
    private $publicPath;

    /** @var string */
    private $storagePath;

    public function __construct($publicPath, $storagePath)
    {
        $this->publicPath = $publicPath;
        $this->storagePath = $storagePath;
    }

    public function getPublicPath(): string
    {
        return $this->publicPath;
    }

    public function getStoragePath(): string
    {
        return $this->storagePath;
    }

    public function toJSON(): array
    {
        return [
            'public_path' => $this->getPublicPath(),
            'storage_path' => $this->getStoragePath(),
        ];
    }

    public function getCode(): string
    {
        return self::SOURCE_CODE;
    }
}