<?php
namespace Domain\Avatar\Image;

use Application\Util\JSONSerializable;

class ImageCollection implements JSONSerializable
{
    const MIN_ID_LENGTH = 3;
    const MAX_ID_LENGTH = 32;

    /** @var Image[] */
    private $images = [];

    static public function createFromJSON(array $json): self {
        $collection = new self();

        foreach($json as $id => $definition) {
            if(! (is_string($id) && strlen($id) >= self::MIN_ID_LENGTH && strlen($id) <= self::MAX_ID_LENGTH)) {
                throw new \InvalidArgumentException(sprintf('Invalid ID `%s`', $id));
            }

            $collection->attachImage($id, new Image(
                $definition['storage_path'],
                $definition['public_path']
            ));
        }

        return $collection;
    }

    public function toJSON(): array
    {
        $result = [];

        foreach($this->images as $id => $image) {
            $result[$id] = ['id' => $id] + $image->toJSON();
        }

        return $result;
    }

    public function attachImage(string $id, Image $image): self
    {
        if(! (is_string($id) && strlen($id) >= self::MIN_ID_LENGTH && strlen($id) <= self::MAX_ID_LENGTH)) {
            throw new \InvalidArgumentException(sprintf('Invalid ID `%s`', $id));
        }

        $this->images[$id] = $image;

        return $this;
    }

    public function detachImage(string $id): self
    {
        if(isset($this->images[$id])) {
            unset($this->images[$id]);
        }

        return $this;
    }

    public function hasImage(string $id): bool
    {
        return isset($this->images[$id]);
    }

    public function getImage(string $id): Image
    {
        return $this->images[$id];
    }
}