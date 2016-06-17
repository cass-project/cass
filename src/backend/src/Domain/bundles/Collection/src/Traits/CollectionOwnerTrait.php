<?php
namespace Domain\Collection\Traits;

use Domain\Collection\Collection\CollectionTree;

trait CollectionOwnerTrait
{
    /**
     * @Column(type="object")
     * @var CollectionTree
     */
    public $collections;

    public function getCollections(): CollectionTree
    {
        return $this->collections;
    }

    public function replaceCollections(CollectionTree $collectionTree): self
    {
        $this->collections = $collectionTree;

        return $this;
    }

    public function notifyUpdateCollections(): self
    {
        // DOCTRINE2 Issue: Doctrine2 won't update collection value without this fix

        $this->collections = clone $this->collections;

        return $this;
    }
}