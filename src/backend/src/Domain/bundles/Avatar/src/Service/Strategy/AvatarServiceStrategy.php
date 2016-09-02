<?php
namespace CASS\Domain\Avatar\Service\Strategy;

use CASS\Domain\Avatar\Image\ImageCollection;

use CASS\Domain\Avatar\Strategy\ImageStrategy;
use Intervention\Image\Image;

interface AvatarServiceStrategy
{
    public function getImageFromPath(string $path): Image;
    public function cropImage(Image $source, int $width, int $height, int $startX, int $startY): Image;
    public function generateImagesFromPath(ImageStrategy $strategy, string $path): ImageCollection;
    public function generateImagesFromSource(ImageStrategy $strategy, Image $source): ImageCollection;
    public function generateImagesFromLetter(ImageStrategy $strategy, string $letter): ImageCollection;
}