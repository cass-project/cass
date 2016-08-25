<?php
namespace Domain\Collection\Strategy;

use CASS\Util\Entity\IdEntity\IdEntity;
use Domain\Collection\Collection\CollectionTree\ImmutableCollectionTree;

interface CollectionAwareEntity extends IdEntity
{
    public function getCollections(): ImmutableCollectionTree;
    public function replaceCollections(ImmutableCollectionTree $collectionTree): ImmutableCollectionTree;
}