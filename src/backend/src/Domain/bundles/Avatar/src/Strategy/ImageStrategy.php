<?php
namespace CASS\Domain\Avatar\Strategy;

use CASS\Domain\Avatar\Entity\ImageEntity;
use CASS\Domain\Avatar\Image\Image;
use League\Flysystem\FilesystemInterface;

interface ImageStrategy
{
    public function getEntity(): ImageEntity;
    public function getEntityId(): string;
    public function getLetter(): string;
    public function getFilesystem(): FilesystemInterface;
    public function getPublicPath(): string;
    public function getDefaultImage(): Image;
    public function getDefaultSize(): int;
    public function getSizes(): array;
    public function getRatio(): string;
    public function validate(\Intervention\Image\Image $origImage);
}