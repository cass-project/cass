<?php
namespace Domain\Collection\Collection;

use Application\Util\JSONSerializable;
use Application\Util\SerialManager\SerialEntity;

class CollectionItem implements SerialEntity, JSONSerializable
{
    /** @var int */
    private $collectionId;

    /** @var int */
    private $position;

    /** @var CollectionTree */
    private $sub;

    public function __construct($collectionId, $position)
    {
        $this->collectionId = $collectionId;
        $this->position = $position;
        $this->sub = new CollectionTree();
    }

    public function toJSON(): array
    {
        return [
            'collection_id' => $this->getCollectionId(),
            'position' => $this->getPosition(),
            'sub' => array_map(function(CollectionItem $item) {
                return $item->toJSON();
            }, $this->sub()->getItems())
        ];
    }

    public function getCollectionId(): int
    {
        return $this->collectionId;
    }

    public function getPosition(): int
    {
        return $this->position;
    }
    
    public function hasChildren(): bool
    {
        return $this->sub()->size() > 0;
    }

    public function sub(): CollectionTree
    {
        return $this->sub;
    }

    public function replaceSub(CollectionTree $tree)
    {
        $this->sub = $tree;
    }

    public function setPosition(int $position)
    {
        $this->position = $position;
    }

    public function incrementPosition()
    {
        ++$this->position;
    }
}