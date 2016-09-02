<?php
namespace CASS\Domain\Bundles\Collection\Collection;

interface CollectionTree
{
    /** @return CollectionItem[] */
    public function getItems(): array ;
}