<?php
namespace Domain\Avatar\Strategy;

use Domain\Avatar\Entity\ImageEntity;
use Domain\Avatar\Image\Image;
use League\Flysystem\Filesystem;

interface AvatarStrategy
{
    public function getEntity(): ImageEntity;
    public function getEntityId(): string;
    public function getLetter(): string;
    public function getFilesystem(): Filesystem;
    public function getPublicPath(): string;
    public function getDefaultImage(): Image;
    public function getDefaultSize(): int;
    public function getSizes(): array;
    public function getRatio(): string;
    public function validate(\Intervention\Image\Image $origImage);
}