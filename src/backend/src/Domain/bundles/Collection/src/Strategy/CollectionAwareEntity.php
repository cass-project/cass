<?php
namespace CASS\Domain\Bundles\Collection\Strategy;

use ZEA2\Platform\Markers\IdEntity\IdEntity;
use CASS\Domain\Bundles\Collection\Collection\CollectionTree\ImmutableCollectionTree;

interface CollectionAwareEntity extends IdEntity
{
    public function getCollections(): ImmutableCollectionTree;
    public function replaceCollections(ImmutableCollectionTree $collectionTree): ImmutableCollectionTree;
}