<?php
namespace CASS\Domain\Avatar\Entity;

use CASS\Domain\Avatar\Image\ImageCollection;

trait ImageEntityTrait
{
    /**
     * @Column(type="json_array")
     * @var array
     */
    private $image = [];

    public function getImages(): ImageCollection
    {
        return ImageCollection::createFromJSON($this->image);
    }

    public function hasImages(): bool
    {
        return count($this->image) > 0;
    }

    public function setImages(ImageCollection $images)
    {
        $this->image = $images->toJSON();

        return $this;
    }
}