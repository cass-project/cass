<?php
namespace Domain\Collection\Collection\CollectionTree;

use Application\Util\JSONSerializable;
use Application\Util\SerialManager\SerialManager;
use Domain\Collection\Collection\CollectionItem;
use Domain\Collection\Collection\CollectionTreeFactory;
use Domain\Collection\Exception\CollectionExistsException;

class MutableCollectionTree implements JSONSerializable, \Serializable
{
    /** @var CollectionItem[] */
    private $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function createImmutableInstance(): ImmutableCollectionTree
    {
        return new ImmutableCollectionTree($this->items);
    }
    
    public function attachChild(int $collectionId, int $position = null): CollectionItem
    {
        if($this->hasCollection($collectionId)) {
            throw new CollectionExistsException(sprintf('Child with collectionId `%d` already exists', $collectionId));
        }

        if($position === null) {
            $position = count($this->items) + 1;
        }

        $this->items[] = ($item = new CollectionItem($collectionId, $position));

        $this->normalize();

        return $item;
    }

    public function detachChild(int $collectionId)
    {
        foreach($this->items as $index => $subItem) {
            if($subItem->getCollectionId() === $collectionId) {
                unset($this->items[$index]);
            }

            if($subItem->sub()->hasChild()) {
                $subItem->sub()->detachChild($collectionId);
            }
        }

        $this->normalize();
    }

    public function hasCollection(int $collectionId): bool
    {
        foreach($this->items as $subItem) {
            if($subItem->getCollectionId() === $collectionId) {
                return true;
            }

            if($subItem->sub()->hasChild()) {
                if($subItem->sub()->hasCollection($collectionId)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function hasChild(): bool
    {
        return count($this->items) > 0;
    }

    public function normalize()
    {
        $serialManager = new SerialManager($this->items);
        $serialManager->normalize();

        $reorder = [];

        for($i = 1; $i <= count($this->items); $i++) {
            $reorder[] = $serialManager->locate($i);
        }

        if(count($reorder) !== count($this->items)) {
            throw new \Exception('SerialManager did something completely wrong.');
        }

        $this->items = $reorder;

        foreach($this->items as $subItem) {
            if($subItem->sub()->hasChild()) {
                $subItem->sub()->normalize();
            }
        }
    }

    public function serialize()
    {
        return json_encode($this->toJSON());
    }

    public function unserialize($serialized)
    {
        CollectionTreeFactory::createFromJSON(json_decode($serialized, true), $this);
    }

    public function size(): int
    {
        return count($this->items);
    }

    public function toJSON(): array
    {
        return array_map(function(CollectionItem $item) {
            return $item->toJSON();
        }, $this->getItems());
    }
}