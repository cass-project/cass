<?php
namespace CASS\Domain\Bundles\Avatar\Entity;

use CASS\Domain\Bundles\Avatar\Image\ImageCollection;

interface ImageEntity
{
    public function getImages(): ImageCollection;
    public function hasImages(): bool;
    public function setImages(ImageCollection $images);
}