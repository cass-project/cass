<?php
namespace CASS\Domain\Bundles\Community\Backdrop\Upload;

use CASS\Domain\Bundles\Community\Backdrop\Preset\CommunityBackdropPresetFactory;
use CASS\Domain\Bundles\Community\Entity\Community;
use League\Flysystem\FilesystemInterface;

final class CommunityBackdropUploadStrategyFactory
{
    /** @var string */
    private $wwwPath;

    /** @var string */
    private $storagePath;

    /** @var FilesystemInterface */
    private $fileSystem;

    /** @var CommunityBackdropPresetFactory */
    private $presetsFactory;

    public function __construct(
        string $wwwPath,
        string $storagePath,
        FilesystemInterface $fileSystem,
        CommunityBackdropPresetFactory $presetsFactory
    ) {
        $this->wwwPath = $wwwPath;
        $this->storagePath = $storagePath;
        $this->fileSystem = $fileSystem;
        $this->presetsFactory = $presetsFactory;
    }

    public function createStrategyFor(Community $community)
    {
        return new CommunityBackdropUploadStrategy(
            $community,
            $this->fileSystem,
            $this->presetsFactory,
            $this->wwwPath,
            $this->storagePath
        );
    }
}