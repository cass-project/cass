<?php
namespace CASS\Domain\Bundles\Profile\Backdrop\Upload;

use CASS\Domain\Bundles\Profile\Backdrop\Preset\ProfileBackdropPresetFactory;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use League\Flysystem\FilesystemInterface;

final class ProfileBackdropUploadStrategyFactory
{
    /** @var string */
    private $wwwPath;

    /** @var string */
    private $storagePath;

    /** @var FilesystemInterface */
    private $fileSystem;

    /** @var ProfileBackdropPresetFactory */
    private $presetsFactory;

    public function __construct(
        string $wwwPath,
        string $storagePath,
        FilesystemInterface $fileSystem,
        ProfileBackdropPresetFactory $presetsFactory
    ) {
        $this->wwwPath = $wwwPath;
        $this->storagePath = $storagePath;
        $this->fileSystem = $fileSystem;
        $this->presetsFactory = $presetsFactory;
    }

    public function createStreategyFor(Profile $profile)
    {
        return new ProfileBackdropUploadStrategy(
            $profile,
            $this->fileSystem,
            $this->presetsFactory,
            $this->wwwPath,
            $this->storagePath
        );
    }
}