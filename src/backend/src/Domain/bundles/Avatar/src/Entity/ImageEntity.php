<?php
namespace Domain\Avatar\Entity;

use Domain\Avatar\Image\ImageCollection;

interface ImageEntity
{
    public function getImages(): ImageCollection;
    public function hasImages(): bool;
    public function setImages(ImageCollection $images);
}