<?php
namespace Domain\Avatar\Entity;

use Domain\Avatar\Image\ImageCollection;

interface ImageEntity
{
    public function fetchImages(): ImageCollection;
    public function hasImages(): bool;
    public function exportImages(ImageCollection $images);
}