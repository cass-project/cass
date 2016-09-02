<?php
namespace CASS\Domain\Bundles\Collection\Strategy\Traits;

use CASS\Domain\Bundles\Collection\Collection\CollectionTree\ImmutableCollectionTree;

trait CollectionAwareEntityTrait
{
    /**
     * @Column(type="object")
     * @var ImmutableCollectionTree
     */
    public $collections;

    public function getCollections(): ImmutableCollectionTree
    {
        return $this->collections;
    }

    public function replaceCollections(ImmutableCollectionTree $collectionTree): ImmutableCollectionTree
    {
        $this->collections = $collectionTree;

        return $collectionTree;
    }
}