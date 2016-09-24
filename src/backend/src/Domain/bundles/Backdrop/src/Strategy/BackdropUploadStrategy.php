<?php
namespace CASS\Domain\Bundles\Backdrop\Strategy;

use CASS\Domain\Bundles\Backdrop\Entity\BackdropEntityAware;
use CASS\Domain\Bundles\Backdrop\Factory\PresetFactory;
use League\Flysystem\Filesystem;

interface BackdropUploadStrategy
{
    public function getStoragePath(): string;
    public function getPublicPath(): string;
    public function getFileSystem(): Filesystem;
    public function getPresetFactory(): PresetFactory;
    public function getMinImageWidth(): int;
    public function getMinImageHeight(): int;
    public function getMaxImageWidth(): int;
    public function getMaxImageHeight(): int;
    public function getMaxFileSize(): int;
}