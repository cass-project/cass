<?php
namespace Domain\Collection\Traits;

use Domain\Collection\Collection\CollectionTree;

trait CollectionOwnerTrait
{
    /**
     * @Column(type="object")
     * @var CollectionTree
     */
    private $collections;

    public function getCollections(): CollectionTree
    {
        return $this->collections;
    }

    public function replaceCollections(CollectionTree $collectionTree): self
    {
        $this->collections = $collectionTree;

        return $this;
    }
}