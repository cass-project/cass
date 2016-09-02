<?php
namespace CASS\Domain\Avatar\Entity;

use CASS\Domain\Avatar\Image\ImageCollection;

interface ImageEntity
{
    public function getImages(): ImageCollection;
    public function hasImages(): bool;
    public function setImages(ImageCollection $images);
}