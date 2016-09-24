<?php
namespace CASS\Domain\Bundles\Backdrop\Strategy;

use CASS\Domain\Bundles\Backdrop\Factory\PresetFactory;
use League\Flysystem\FilesystemInterface;

interface BackdropUploadStrategy
{
    public function getStoragePath(): string;
    public function getPublicPath(): string;
    public function getFileSystem(): FilesystemInterface;
    public function getPresetFactory(): PresetFactory;
    public function getMinImageWidth(): int;
    public function getMinImageHeight(): int;
    public function getMaxImageWidth(): int;
    public function getMaxImageHeight(): int;
    public function getMaxFileSize(): int;
}