<?php
namespace Domain\Avatar\Service\Context;

use Domain\Avatar\Entity\ImageEntityTrait;
use Domain\Avatar\Image\Image;
use League\Flysystem\Filesystem;

interface AvatarStrategy
{
    public function getEntity(): ImageEntityTrait;
    public function getLetter(): string;
    public function getFilesystem(): Filesystem;
    public function getPublicPath(): string;
    public function getDefaultImage(): Image;
}