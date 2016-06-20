<?php
namespace Domain\Collection\Collection;

interface CollectionTree
{
    /** @return CollectionItem[] */
    public function getItems(): array ;
}