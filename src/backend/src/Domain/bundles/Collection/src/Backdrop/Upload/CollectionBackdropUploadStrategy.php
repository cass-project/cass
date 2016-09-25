<?php
namespace CASS\Domain\Bundles\Collection\Backdrop\Upload;

use CASS\Domain\Bundles\Backdrop\Factory\PresetFactory;
use CASS\Domain\Bundles\Backdrop\Strategy\BackdropUploadStrategy;
use CASS\Domain\Bundles\Collection\Backdrop\Preset\CollectionBackdropPresetFactory;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use League\Flysystem\FilesystemInterface;

final class CollectionBackdropUploadStrategy implements BackdropUploadStrategy
{
    const IMAGE_MIN_SIZE = 400;
    const IMAGE_MAX_SIZE = 2048;
    const FILE_MAX_LENGTH = 3 /* mb */ * 1024 /* kb */ * 1024 /* b */;

    /** @var Collection */
    private $collection;

    /** @var FilesystemInterface */
    private $fileSystem;

    /** @var CollectionBackdropPresetFactory */
    private $presetsFactory;

    /** @var string */
    private $publicPath;

    /** @var string */
    private $storagePath;

    public function __construct(
        Collection $collection,
        FilesystemInterface $fileSystem,
        CollectionBackdropPresetFactory $presetsFactory,
        string $publicPath,
        string $storagePath
    ) {
        $this->collection = $collection;
        $this->fileSystem = $fileSystem;
        $this->presetsFactory = $presetsFactory;
        $this->publicPath = $publicPath;
        $this->storagePath = $storagePath;
    }

    public function getStoragePath(): string
    {
        return $this->storagePath;
    }

    public function getPublicPath(): string
    {
        return $this->publicPath;
    }

    public function getFileSystem(): FilesystemInterface
    {
        return $this->fileSystem;
    }

    public function getPresetFactory(): PresetFactory
    {
        return $this->presetsFactory;
    }

    public function getMinImageWidth(): int
    {
        return self::IMAGE_MIN_SIZE;
    }

    public function getMinImageHeight(): int
    {
        return self::IMAGE_MIN_SIZE;
    }

    public function getMaxImageWidth(): int
    {
        return self::IMAGE_MAX_SIZE;
    }

    public function getMaxImageHeight(): int
    {
        return self::IMAGE_MAX_SIZE;
    }

    public function getMaxFileSize(): int
    {
        return self::FILE_MAX_LENGTH;
    }
}