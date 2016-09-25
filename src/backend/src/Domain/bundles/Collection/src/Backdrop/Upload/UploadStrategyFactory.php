<?php
namespace CASS\Domain\Bundles\Collection\Backdrop\Upload;

use CASS\Domain\Bundles\Collection\Backdrop\Preset\CollectionBackdropPresetFactory;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use League\Flysystem\FilesystemInterface;

final class UploadStrategyFactory
{
    /** @var string */
    private $wwwPath;

    /** @var string */
    private $storagePath;

    /** @var FilesystemInterface */
    private $fileSystem;

    /** @var CollectionBackdropPresetFactory */
    private $presetsFactory;

    public function __construct(
        string $wwwPath,
        string $storagePath,
        FilesystemInterface $fileSystem,
        CollectionBackdropPresetFactory $presetsFactory
    ) {
        $this->wwwPath = $wwwPath;
        $this->storagePath = $storagePath;
        $this->fileSystem = $fileSystem;
        $this->presetsFactory = $presetsFactory;
    }

    public function createStreategyFor(Collection $collection)
    {
        return new UploadStrategy(
            $collection,
            $this->fileSystem,
            $this->presetsFactory,
            $this->wwwPath,
            $this->storagePath
        );
    }
}