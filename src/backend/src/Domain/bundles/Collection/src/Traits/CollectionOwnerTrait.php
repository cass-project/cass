<?php
namespace Domain\Collection\Traits;

use Domain\Collection\Collection\CollectionTree;
use Domain\Collection\Entity\Collection;

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

    public function setCollection(Collection $collection):self
    {
        $this->collections[] = $collection;
        return $this;
    }
}