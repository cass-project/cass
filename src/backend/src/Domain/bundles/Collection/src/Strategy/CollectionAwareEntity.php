<?php
namespace CASS\Domain\Bundles\Collection\Strategy;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Domain\Bundles\Collection\Collection\CollectionTree\ImmutableCollectionTree;

interface CollectionAwareEntity extends IdEntity
{
    public function getCollections(): ImmutableCollectionTree;
    public function replaceCollections(ImmutableCollectionTree $collectionTree): ImmutableCollectionTree;
}