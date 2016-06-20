<?php
namespace Domain\Collection\Collection\CollectionTree;

use Application\Util\JSONSerializable;
use Domain\Collection\Collection\CollectionItem;
use Domain\Collection\Collection\CollectionTree;

final class ImmutableCollectionTree implements CollectionTree, JSONSerializable
{
    /** @var CollectionItem[] */
    private $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function createMutableInstance(): MutableCollectionTree
    {
        return new MutableCollectionTree($this->items);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function toJSON(): array
    {
        return array_map(function(CollectionItem $item) {
            return $item->toJSON();
        }, $this->getItems());
    }
}